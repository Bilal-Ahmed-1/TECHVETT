<?php



use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\CandidateSqaController;
use App\Http\Controllers\EmailController;

Route::get('send-email', [EmailController::class, 'sendEmail']);

Route::get('/candidate-sqa', [CandidateSqaController::class, 'index']);
Route::post('/candidate-sqa', [CandidateSqaController::class, 'store']);
Route::put('/candidate-sqa/{id}', [CandidateSqaController::class, 'update']);
Route::delete('/candidate-sqa/{id}', [CandidateSqaController::class, 'destroy']);

use App\Http\Controllers\CandidateNetworkingController;

Route::get('/candidate-networking', [CandidateNetworkingController::class, 'index']);
Route::post('/candidate-networking', [CandidateNetworkingController::class, 'store']);
Route::put('/candidate-networking/{id}', [CandidateNetworkingController::class, 'update']);
Route::delete('/candidate-networking/{id}', [CandidateNetworkingController::class, 'destroy']);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('send-email', [EmailController::class, 'sendEmail']);

use App\Http\Controllers\TestScoreController;
Route::get('/test-scores', [TestScoreController::class, 'index']);


// Register routes
Route::get('/register', [RegisterController::class, 'show'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login routes
Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

// Logout route
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Dashboard route for authenticated users (serves the Vue.js SPA)
Route::get('/dashboard/{any?}', function () {
    return view('app'); // Load app.blade.php for the Vue.js SPA
})
    ->middleware('auth') // Ensures only authenticated users can access
    ->where('any', '.*') // Catch-all for Vue Router paths
    ->name('dashboard');

// candidate selection

Route::get('/candidate-selection', [CandidateController::class, 'index']);
Route::post('/send-email', [CandidateController::class, 'sendEmail'])->name('send.email');



// Redirect root to login if not authenticated, or dashboard if authenticated
// Route::get('/', function () {
//     if (auth()->check()) {
//         return redirect()->route('dashboard');
//     }
//     return redirect()->route('login');
// });