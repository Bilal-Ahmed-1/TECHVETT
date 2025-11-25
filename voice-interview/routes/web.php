<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VoiceController;

Route::get('/', [VoiceController::class, 'index']); // loads interview UI
Route::get('/result', [VoiceController::class, 'result']); // shows result page

Route::get('/interview/result', function () {
    return view('interview.result', [
        'score' => session('final_score'),
        'rating' => session('final_rating')
    ]);
})->name('interview.result');
