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


Route::redirect('/', '/score');
Route::resource('score', ScoreController::class);
Route::get('/data-bergolong', [ScoreController::class, 'bergolong']);
Route::get('/distribusi-frekuensi', [ScoreController::class, 'distribusiFrekuensi']);
Route::get('/chi', [ScoreController::class, 'getChiSqure']);
Route::post('/chi', [ScoreController::class, 'calculateChiSqure'])->name('chi');
Route::get('/t', [ScoreController::class, 'ujiT']);
