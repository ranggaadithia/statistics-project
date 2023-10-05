<?php

use App\Http\Controllers\ScoreController;
use App\Models\Score;
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


// Route::get('/', [ScoreController::class, 'index'])->name('scores.index');
// Route::post('/', [ScoreController::class, 'store'])->name('scores.store');
// Route::post('/{id}', [ScoreController::class, 'destroy'])->name('scores.destroy');
Route::resource('score', ScoreController::class);
