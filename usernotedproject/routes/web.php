<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\SignupController;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\forgetcontroller;
use App\Http\Controllers\dashbordcontroller;
use App\Http\Controllers\logoutcontroller;
use App\Http\Controllers\editcontroller;
use App\Http\Controllers\googlecontroller;


Route::controller(SignupController::class)->group(function () {
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/signupaction', 'signupactions')->name('signupaction');
});


Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/loginaction', 'loginactions')->name('loginaction');
});
Route::middleware(['authCheck'])->group(function () {
    Route::get('/dashboard', [DashbordController::class, 'dashbordaction'])->name('dashboard');
});


// for email
Route::get('/forget_email', [forgetcontroller::class, 'forgetemail'])->name('forget_email');


Route::controller(logoutcontroller::class)->group(function ()
{
    Route::get('/logout', 'logout')->name('logout');
});
Route::controller(editcontroller::class)->group(function ()
{
    Route::get('/edit_profile/{id}', 'edit')->name('edit_profile');
});
Route::get('/hiden_div',[SignupController::class,'hiden_div'])->name('hiden_div');



Route::get('/auth/google', [googlecontroller::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/google/callback', [googlecontroller::class, 'handleGoogleCallback']);
Route::get('/logout', [googleController::class, 'logout'])->name('logout');