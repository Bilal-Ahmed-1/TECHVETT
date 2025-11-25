<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Level;
use App\Models\Question;
use App\Models\Option;
use App\Models\Test;
use App\Models\TestResult;
use App\Models\Answer;
use App\Models\Stage2Question;
use App\Models\Stage2Answer;
use App\Models\Stage2Result;
use App\Models\Stage2Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function getCategories()
    {
        return response()->json(Category::all());
    }

    public function getLevels()
    {
        return response()->json(Level::all());
    }

    public function startQuiz(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'level_id' => 'required|exists:levels,id',
        ]);

        $test = Test::create([
            'user_id' => auth()->id() ?? 1,
            'category_id' => $validated['category_id'],
            'level_id' => $validated['level_id'],
        ]);

        return response()->json(['test_id' => $test->id], 201);
    }

    public function getQuestions($testId)
    {
        try {
            $test = Test::find($testId);
            if (!$test) {
                return response()->json(['error' => 'Test not found'], 404);
            }

            $questions = Question::where('category_id', $test->category_id)
                ->where('level_id', $test->level_id)
                ->with('options:id,question_id,option_text,is_correct')
                ->inRandomOrder()
                ->take(15)
                ->get(['id', 'question_text', 'category_id', 'level_id']);

            if ($questions->isEmpty()) {
                return response()->json(['message' => 'No questions found for the selected category and level'], 404);
            }

            return response()->json($questions);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Database error fetching questions',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching questions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function submitAnswer(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'option_id' => 'required|exists:options,id',
        ]);

        try {
            Answer::create([
                'user_id' => auth()->id(),
                'question_id' => $validated['question_id'],
                'option_id' => $validated['option_id'],
            ]);

            return response()->json(['message' => 'Answer submitted successfully']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error saving answer', 'error' => $e->getMessage()], 500);
        }
    }

    public function getResult($testId)
    {
        $test = Test::find($testId);
        if (!$test) {
            return response()->json(['error' => 'Test not found'], 404);
        }

        $answers = Answer::where('user_id', auth()->id())
            ->whereHas('question', function ($query) use ($test) {
                $query->where('category_id', $test->category_id)
                    ->where('level_id', $test->level_id);
            })
            ->with('option:id,is_correct')
            ->get();

        $correct = $answers->where('option.is_correct', true)->count();
        $total = collect($answers)->unique('question_id')->count();

        // Save the result to the database
        try {
            TestResult::create([
                'user_id' => auth()->id(),
                'test_id' => $testId,
                'correct' => $correct,
                'total' => $total,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error saving test result',
                'error' => $e->getMessage(),
            ], 500);
        }

        return response()->json([
            'correct' => $correct,
            'total' => $total,
        ]);
    }

    /** -------------------- STAGE 2 -------------------- **/

    public function getStage2Question($testId)
    {
        try {
            $test = Test::find($testId);
            if (!$test) {
                return response()->json(['error' => 'Test not found'], 404);
            }

            $questions = Stage2Question::where('category_id', $test->category_id)
                ->where('level_id', $test->level_id)
                ->inRandomOrder()
                ->take(10)
                ->get();

            if ($questions->isEmpty()) {
                return response()->json(['message' => 'No Stage 2 questions found for the selected category and level'], 404);
            }

            $formattedQuestions = $questions->map(function ($question) {
                return [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'image_path' => $question->image_path,
                    'option_1' => $question->option_1,
                    'option_2' => $question->option_2,
                    'option_3' => $question->option_3,
                    'option_4' => $question->option_4,
                    'option_5' => $question->option_5,
                ];
            });

            return response()->json(['questions' => $formattedQuestions]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json([
                'message' => 'Database error fetching Stage 2 questions',
                'error' => $e->getMessage(),
            ], 500);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching Stage 2 questions',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function submitStage2Answer(Request $request)
    {
        $validated = $request->validate([
            'question_id' => 'required|exists:stage2_questions,id',
            'selected_option' => 'required|in:1,2,3,4,5',
            'reason' => 'nullable|string',
        ]);

        try {
            Stage2Response::create([
                'user_id' => auth()->id(),
                'stage2_question_id' => $validated['question_id'],
                'selected_option' => $validated['selected_option'],
                'reason' => $validated['reason'],
            ]);

            return response()->json(['message' => 'Stage 2 response submitted successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error saving stage 2 response',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getStage2Result()
    {
        try {
            $responses = Stage2Response::with('question')
                ->where('user_id', auth()->id())
                ->get();

            $total = $responses->count();
            $correct = $responses->filter(function ($response) {
                return $response->question && $response->selected_option == $response->question->correct_option;
            })->count();
            $wrong = $responses->filter(function ($response) {
                return $response->question && $response->selected_option != $response->question->correct_option;
            })->count();

            $answers = $responses->map(function ($response) {
                $isCorrect = $response->question && $response->selected_option == $response->question->correct_option;
                return [
                    'question_text' => $response->question ? $response->question->question_text : 'Question not found',
                    'selected_option' => $response->selected_option,
                    'correct_option' => $response->question ? $response->question->correct_option : null,
                    'is_correct' => $isCorrect,
                    'reason' => $response->reason,
                ];
            });

            // Save the result to the database
            Stage2Result::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'correct' => $correct,
                'wrong' => $wrong,
                'answers' => $answers, // Store as JSON
            ]);

            return response()->json([
                'total' => $total,
                'correct' => $correct,
                'wrong' => $wrong,
                'answers' => $answers,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching stage 2 results',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}