<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Option;
use App\Models\User;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // // Create a guest user if it doesn't exist, or get an existing one
        // $guestUser = User::firstOrCreate(
        //     ['email' => 'guest@example.com'], // You can modify this if needed
        //     [
        //         'name' => 'Guest User',
        //         'password' => bcrypt('password'),
        //         'location' => 'Unknown',
        //         'cnic' => '00000-0000000-0', // Provide a default CNIC value
        //         'age' => 18, // Provide a default age
        //         'field' => 'General', // Provide a default field
        //         'qualification' => 'None', // Provide a default qualification
        //         'jobrole' => 'sqa',
        //         'experience' => 'Advanced',
        //     ]
        // );
        
        $questions = Question::all(); // Fetch all seeded questions

        foreach ($questions as $question) {
            // Find the correct option for the question
            $correctOption = Option::where('question_id', $question->id)
                ->where('is_correct', true)
                ->first();

            // // Ensure there is a valid guest user and correct option
            // if ($guestUser && $correctOption) {
            //     Answer::create([
            //         'user_id' => $user->id, // Use guest user ID
            //         'question_id' => $question->id,
            //         'option_id' => $correctOption->id, // Link to correct option
            //     ]);
            // }
        }
    }
}