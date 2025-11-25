<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
         User::create([
            'name' => 'Dawood',
            'email' => 'dawoodm.shoaib@gmail.com',
            'location' => 'Karachi',
            'cnic' => '42101-1234567-1',
            'age' => 25,
            'jobrole' => 'sqa',
            'experience' => 'Basic',
            'field' => 'Software Engineering',
            'qualification' => 'BSCS',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'name' => 'Dawood2',
            'email' => 'dawoodmshoaib@gmail.com',
            'location' => 'Lahore',
            'cnic' => '35202-9876543-2',
            'age' => 28,
            'jobrole' => 'networking',
            'experience' => 'Advance',
            'field' => 'Data Science',
            'qualification' => 'MS Data Science',
            'password' => bcrypt('password'),
        ]);
    }
}
