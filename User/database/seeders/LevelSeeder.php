<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Level;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Level::firstOrCreate(['name' => 'Basic'], ['time_limit' => 30]);
        Level::firstOrCreate(['name' => 'Intermediate'], ['time_limit' => 45]);
        Level::firstOrCreate(['name' => 'Advanced'], ['time_limit' => 60]);
    }
}
