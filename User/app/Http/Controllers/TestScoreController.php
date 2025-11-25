<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TestScore;
use App\Models\TestResult;
use App\Models\Stage2Result;
use App\Models\Stage3Result;

class TestScoreController extends Controller
{
    public function updateOrCreateScores()
    {
        // Fetch all users
        $users = User::all();

        foreach ($users as $user) {
            $stage1 = TestResult::where('user_id', $user->id)->value('correct') ?? 0;
            $stage2 = Stage2Result::where('user_id', $user->id)->value('correct') ?? 0;
            $stage3 = Stage3Result::where('user_id', $user->id)->value('score') ?? 0;

            // Update or create record in test_score
            \App\Models\TestScore::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => $user->name,
                    'field' => $user->field,
                    'jobrole' => $user->jobrole,
                    'experience' => $user->experience,
                    'stage1' => $stage1,
                    'stage2' => $stage2,
                    'stage3' => $stage3,
                ]
            );
        }

        return response()->json(['message' => 'Test scores updated successfully']);
    }
}
