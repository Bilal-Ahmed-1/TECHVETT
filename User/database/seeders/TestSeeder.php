<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Test;
use App\Models\Category;
use App\Models\Level;
use App\Models\User;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first();
        $category = Category::first();
        $level = Level::first();

        // Ensure all needed foreign keys exist
        if (!$user || !$category || !$level) {
            $this->command->error('User, Category or Level not found. Please seed them first.');
            return;
        }

        Test::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'level_id' => $level->id,
            'time_taken' => 30,
        ]);

        Test::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'level_id' => $level->id,
            'time_taken' => 40,
        ]);
    }
}
