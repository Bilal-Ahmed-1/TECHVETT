<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            LevelSeeder::class,
            QuestionSeeder::class,
            Stage2QuestionsSeeder::class,
            Stage3ResultSeeder::class,
            OptionSeeder::class,
            AnswerSeeder::class,
            TestSeeder::class,
            Stage2ResultSeeder::class,
            TestResultSeeder::class,
        ]);
    }
}
