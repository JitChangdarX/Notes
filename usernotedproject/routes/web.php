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
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\forgetcontroller;

Route::controller(SignupController::class)->group(function () {
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/signupaction', 'signupactions')->name('signupaction');
});
Route::controller(logincontroller::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/loginaction', 'loginactions')->name('loginaction');
});

Route::controller(dashbordcontroller::class)->group(function () {
    Route::get('/dashbord', 'dashbordaction')->name('dashbord');
});

Route::get('/forget_password', [forgetcontroller::class, 'forgetpassword'])->name('forgetpassword');