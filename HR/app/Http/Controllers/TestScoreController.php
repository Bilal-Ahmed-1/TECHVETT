<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestScore;
use Illuminate\Support\Facades\DB;

class TestScoreController extends Controller
{
    public function index()
    {
         try {
              $scores = TestScore::select(
                    'user_id',
                    'name',
                    'field',
                    'jobrole',       // <- this MUST match your DB column
                    'experience',
                    'stage1',
                    'stage2',
                    'stage3'
                )
                ->get();

            return response()->json($scores);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
