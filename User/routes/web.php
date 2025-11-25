<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// use App\Http\Controllers\AssesmentController;
// use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TestScoreController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
    
//     dd(1);
//     return view('auth.login');
// });

// Route::get('/', function () {

//     return view('auth.login');
// });


use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\VoiceController;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');

// Public feedback routes
// Route::get('/feedback', [FeedbackController::class, 'showForm'])->name('feedback.form');
// Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');

// Authentication routes
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Protected dashboard/quiz route
Route::get('/quiz', function () {
    return view('home');
})->middleware('auth')->name('quiz');

// Stage 3 Voice Analysis routes
Route::get('/interview', [VoiceController::class, 'index'])->name('interview'); // Loads interview UI
Route::get('/result', [VoiceController::class, 'result'])->name('result'); // Shows result page
Route::get('/interview/result', function () {
    return view('interview.result', [
        'score' => session('final_score'),
        'rating' => session('final_rating')
    ]);
})->name('interview.result');

Route::get('/update-test-scores', [TestScoreController::class, 'updateOrCreateScores'])->name('update.test.scores');

// Route::get('/feedback', [FeedbackController::class, 'showForm'])->name('feedback.form');
// Route::post('/feedback', [FeedbackController::class, 'submitFeedback'])->name('feedback.submit');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::post('/categories', [AssesmentController::class, 'selectLevel'])->name('categories');

// Route::post('/select-level', [LevelController::class, 'selectLevel'])->name('select-level');
