<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoiceController;


Route::get('/hr-first', [VoiceController::class, 'hrFirst']); // HR welcome voice
Route::post('/speak', [VoiceController::class, 'speak']); // process voice blob

// Route::post('/stt', [VoiceController::class, 'transcribe']);
// Route::post('/cohere', [VoiceController::class, 'respond']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
