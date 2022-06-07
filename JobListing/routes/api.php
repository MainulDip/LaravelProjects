<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// localhost:8000/api/posts
Route::get('/posts', function(){
    return response()->json([
        'posts' => [
            [
                'title' => 'Fist Post',
                'body' => 'Some Description First'
            ],
            [
                'title' => 'Second Post',
                'body' => 'Second Description'
            ]
        ]
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
