<?php

use App\Http\Controllers\ScoreController;
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

Route::resource('/', ScoreController::class)->names([
    'index' => 'scores.index',
    'create' => 'scores.create',
    'store' => 'scores.store',
    'show' => 'scores.show',
    'edit' => 'scores.edit',
    'update' => 'scores.update',
    'destroy' => 'scores.destroy',
]);
