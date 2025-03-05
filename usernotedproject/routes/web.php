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
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\forgetcontroller;
use App\Http\Controllers\dashbordcontroller;
use App\Http\Controllers\logoutcontroller;

Route::controller(SignupController::class)->group(function () {
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/signupaction', 'signupactions')->name('signupaction');
});
Route::controller(logincontroller::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/loginaction', [LoginController::class, 'loginactions'])->name('loginaction');
    // Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});

Route::controller(dashbordcontroller::class)->group(function () {
    Route::get('/dashbord/{id}', 'dashbordaction')->name('dashbord')->middleware('authCheck');
});


// for email
Route::get('/forget_email', [forgetcontroller::class, 'forgetemail'])->name('forget_email');


Route::controller(logoutcontroller::class)->group(function ()
{
    Route::get('/logout', 'logout')->name('logout');
});