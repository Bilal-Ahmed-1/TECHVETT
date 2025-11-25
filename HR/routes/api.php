<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

use App\Http\Controllers\Api\UploadResumeController;

Route::post('/upload-resume', [UploadResumeController::class, 'store']);

Route::post('/candidate-action', [EmailController::class, 'handle']);

use App\Http\Controllers\Api\DashboardSettingsController;

Route::post('/dashboard-settings', [DashboardSettingsController::class, 'save']);
Route::get('/dashboard-data', [DashboardSettingsController::class, 'getDashboardData']);