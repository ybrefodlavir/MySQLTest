<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaterialController;
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

Route::get('/', [MaterialController::class, 'index'])->name('home');
Route::get('/material/{material_id}', [MaterialController::class, 'details'])->name('material_detail');

Route::get('/question', [HomeController::class, 'index'])->name('question');
Route::post('/test', [TestController::class, 'index'])->name('test');
