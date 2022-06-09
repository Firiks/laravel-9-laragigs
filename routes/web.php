<?php

use App\Http\Controllers\ListingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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

/**
 * Listings
 */

// index
Route::get('/', [ListingController::class, 'index'])->name('listings.index');

// listings -> index
Route::get('/listings', function() {
  return redirect()->route('listings.index');
});

// manage user listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->name('listings.manage');

// listings resource
Route::resource('listings', ListingController::class)->except(['index']);

/**
 * Users
 */

// register form
Route::get('/register', [UserController::class, 'create'])->name('users.register')->middleware('guest');

// login user form
Route::get('/login', [UserController::class, 'login'])->name('users.login')->middleware('guest');

// create new user
Route::post('/register', [UserController::class, 'store'])->name('users.store')->middleware('guest');

// login registered user
Route::post('/authenticate', [UserController::class, 'authenticate'])->name('users.authenticate');

// logout user
Route::post('/logout', [UserController::class, 'logout'])->name('users.logout')->middleware('auth');