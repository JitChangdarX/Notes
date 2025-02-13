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

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SignupController;
use App\Http\Controllers\dashbordcontroller;

Route::get('/signup', [SignupController::class, 'signup'])->name('signup');
Route::post('/signupaction', [SignupController::class, 'signupactions'])->name('signupaction');
Route::get('/dashbord',[dashbordcontroller::class, 'dashbordaction']);
