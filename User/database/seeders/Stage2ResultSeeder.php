<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Stage2ResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('stage2_results')->insert([
            [
                'user_id' => '1',
                'total' => '10',
                'correct' => '3',
                'wrong' => '7',
                'answers' => '[
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is API testing?",
        "correct_option": 3,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is stress testing?",
        "correct_option": 3,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is a test harness?",
        "correct_option": 1,
        "selected_option": 2
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is the purpose of load testing?",
        "correct_option": 1,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What does test coverage measure?",
        "correct_option": 4,
        "selected_option": 4
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is the benefit of test automation?",
        "correct_option": 2,
        "selected_option": 2
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is integration testing?",
        "correct_option": 2,
        "selected_option": 4
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is the purpose of regression testing?",
        "correct_option": 3,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is black-box testing?",
        "correct_option": 4,
        "selected_option": 2
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is a test suite?",
        "correct_option": 2,
        "selected_option": 3
    }
]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => '2',
                'total' => '10',
                'correct' => '6',
                'wrong' => '4',
                'answers' => '[
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is API testing?",
        "correct_option": 3,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is stress testing?",
        "correct_option": 3,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is a test harness?",
        "correct_option": 1,
        "selected_option": 2
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is the purpose of load testing?",
        "correct_option": 1,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What does test coverage measure?",
        "correct_option": 4,
        "selected_option": 4
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is the benefit of test automation?",
        "correct_option": 2,
        "selected_option": 2
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is integration testing?",
        "correct_option": 2,
        "selected_option": 4
    },
    {
        "reason": "yes",
        "is_correct": true,
        "question_text": "What is the purpose of regression testing?",
        "correct_option": 3,
        "selected_option": 3
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is black-box testing?",
        "correct_option": 4,
        "selected_option": 2
    },
    {
        "reason": "yes",
        "is_correct": false,
        "question_text": "What is a test suite?",
        "correct_option": 2,
        "selected_option": 3
    }
]',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Add more records as needed
        ]);
    }
}
