<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MCQController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\VoiceController;
// use App\Http\Controllers\TestScoreController; 
// use App\Http\Controllers\Api\AssesmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth')->group(function () {
    // These routes are protected by authentication
    Route::get('/categories', [QuizController::class, 'getCategories']);
    Route::get('/levels', [QuizController::class, 'getLevels']);
    Route::post('/start-quiz', [QuizController::class, 'startQuiz']);
    Route::get('/questions/{testId}', [QuizController::class, 'getQuestions']);
    Route::post('/submit-answer', [QuizController::class, 'submitAnswer']);
    Route::get('/quiz-result/{testId}', [QuizController::class, 'getResult']);
    Route::get('/stage2/question/{testId}', [QuizController::class, 'getStage2Question']);
    Route::post('/stage2/submit', [QuizController::class, 'submitStage2Answer']);
    Route::get('/stage2/result', [QuizController::class, 'getStage2Result']);
    // Voice-related routes
    Route::get('/hr-first', [VoiceController::class, 'hrFirst']); // HR welcome voice
    Route::post('/speak', [VoiceController::class, 'speak']); // Process voice blob
    Route::post('/stage3/submit', [VoiceController::class, 'submitStage3']); // Submit Stage 3 audio
});
