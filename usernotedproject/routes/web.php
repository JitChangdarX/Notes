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
Route::controller(editcontroller::class)->group(function ()
{
    Route::get('/edit_profile/{id}', 'edit')->name('edit_profile');
});
Route::get('/hiden_div',[SignupController::class,'hiden_div'])->name('hiden_div');