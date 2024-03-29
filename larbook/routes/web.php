<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/registers', [RegisterController::class, 'index'])->name('registers');

Route::post('/registers', [RegisterController::class, 'store']);

Route::get('/posts', function () {
    // return view('welcome');
    return view('post.index');
});


Route::get('/', function () {
    // return view('welcome');
    // return view('post.index');
});
