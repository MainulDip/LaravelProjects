<?php

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;

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

// All Listing
Route::get('/', [ListingController::class, 'index']);

// Single Listing
// Route::get('/listing/{id}', function ($id) {
//     $single_listing = Listing::find($id);

//     if ($single_listing) {
//         return view('listing', [
//             'heading' => 'Latest Listing',
//             'listing' => $single_listing,
//         ]);
//     } else {
//         abort('404');
//     }
// });

// Create job form
Route::get('/listings/create',[ListingController::class, 'create'])->middleware('auth');

// Storing newly submittend form data for job creation over POST
Route::post('/listings', [ListingController::class, 'store'])->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// Route Model Binding Single Listing
Route::get('/listings/{listing}', [ListingController::class, 'show']);

// Show Listing Edit Form
Route::get('listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');


// Edit Submit To Update
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

// Delete Listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Show Register User Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store'])->middleware('guest');

// Logout
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');


// Login User
Route::post('/users/authenticate', [UserController::class, 'authenticate'])->middleware('guest');



// Route::get('/hello', function () {
//     return response('Hello World', 200)
//         ->header('Content-Type', 'text/plain')
//         ->header('foo', 'bar');
// });

// // http://localhost:8000/post/12
// Route::get('/post/{id}', function ($id) {
//     // ddd($id); // die and dump and debug
//     return response('Post ' . $id);
// })->where('id', '[0-9]+'); // checking url params by regex

// // localhost:8000/search?name=SomeName&city=Where
// Route::get('/search', function (Request $request) {
//     echo $request->name . ' ' . $request->city;
//     dd($request);
// });


