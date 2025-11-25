<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CandidateSqa;
use App\Models\CandidateNetworking;
use App\Models\TestScore;
use App\Models\TestResult;
use App\Models\Stage2Result;
use App\Models\Stage3Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');  // Correct view path
    }

    public function register(Request $request)
    {
        \Log::info('Register Request Data:', $request->all());

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'location' => 'required|string|max:255',
            'cnic' => 'required|string|max:20',
            'age' => 'required|integer|min:1',
            'field' => 'required|string|max:255',
            'qualification' => 'required|string|max:255',
            'jobrole' => 'required|string|max:255',
            'experience' => 'required|string|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'location' => $request->location,
            'cnic' => $request->cnic,
            'age' => $request->age,
            'field' => $request->field,
            'qualification' => $request->qualification,
            'jobrole' => $request->jobrole,
            'experience' => $request->experience,
            'password' => Hash::make($request->password),
        ]);

        // Assign to candidate_sqa or candidate_networking
        if (strtolower($user->jobrole) === 'sqa') {
            CandidateSqa::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'location' => $user->location,
                'cnic' => $user->cnic,
                'age' => $user->age,
                'field' => $user->field,
                'jobrole' => $user->jobrole,
                'experience' => $user->experience,
                'qualification' => $user->qualification,
            ]);
        } elseif (strtolower($user->jobrole) === 'networking') {
            CandidateNetworking::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'location' => $user->location,
                'cnic' => $user->cnic,
                'age' => $user->age,
                'field' => $user->field,
                'jobrole' => $user->jobrole,
                'experience' => $user->experience,
                'qualification' => $user->qualification,
            ]);
        }

        // // Fetch stage results if available
        // $stage1 = TestResult::where('user_id', $user->id)->value('correct') ?? 0;
        // $stage2 = Stage2Result::where('user_id', $user->id)->value('correct') ?? 0;
        // $stage3 = Stage3Result::where('user_id', $user->id)->value('score') ?? 0;

        // // Create test_score entry
        // TestScore::create([
        //     'user_id' => $user->id,
        //     'name' => $user->name,
        //     'field' => $user->field,
        //     'jobrole' => $user->jobrole,
        //     'experience' => $user->experience,
        //     'stage1' => $stage1,
        //     'stage2' => $stage2,
        //     'stage3' => $stage3,
        // ]);

        Auth::login($user);

        return redirect()->route('login')->with('status', 'Registration successful. Please log in.');
    }
}
