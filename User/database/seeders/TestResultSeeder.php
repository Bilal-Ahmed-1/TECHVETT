<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TestResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('test_results')->insert([
            [
                'user_id' => '1',
                'correct' => '5',
                'total' => '15',
                'test_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => '2',
                'correct' => '8',
                'total' => '15',
                'test_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            // Add more records as needed
        ]);
    }
}
