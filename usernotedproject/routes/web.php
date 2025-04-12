<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect()->route('login');
});
use App\Http\Controllers\SignupController;
use App\Http\Controllers\logincontroller;
use App\Http\Controllers\forgetcontroller;
use App\Http\Controllers\dashbordcontroller;
use App\Http\Controllers\logoutcontroller;
use App\Http\Controllers\editcontroller;
use App\Http\Controllers\googlecontroller;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\PageVisitController;
use App\Http\Controllers\OTPController;


Route::controller(SignupController::class)->group(function () {
    Route::get('/signup', 'signup')->name('signup');
    Route::post('/signupaction', 'signupactions')->name('signupaction');
});

Route::controller(CookieController::class)->group(function () {
    Route::post('/accept-cookies', 'acceptCookies')->name('accept.cookies');
    Route::get('/get-cookies', 'getCookies')->name('get.cookies');
    Route::get('/delete-cookies', 'deleteCookies')->name('delete.cookies');
});


Route::controller(LoginController::class)->group(function () {
    Route::get('/logins', 'login')->name('logins'); // ✅ Correct route
    Route::post('/loginaction', 'loginactions')->name('loginaction');
});



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashbord');
    })->name('dashboard');
});


// for email
// Shows the email input form
// Route::get('/forget_email', [forgetcontroller::class, 'forgetemail'])->name('forget_email');

// // Handles sending the reset link
// Route::post('/send-reset-link', [forgetcontroller::class, 'sendResetLink'])->name('send.reset.link');




Route::get('/forgot', [OTPController::class, 'showForm'])->name('otp.form');
Route::post('/send-otp', [OTPController::class, 'sendOtp'])->name('otp.send');
Route::post('/verify-otp', [OTPController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/reset-password', [OTPController::class, 'updatePassword'])->name('password.update');


Route::controller(logoutController::class)->group(function () {
    Route::post('/logout', 'logout')->name('logout');
});
Route::controller(editcontroller::class)->group(function ()
{
    Route::get('/edit_profile/{id}', [editcontroller::class, 'edit'])->name('edit_profile');
    Route::put('/update_profile/{id}', [editcontroller::class, 'update'])->name('update_profile');
});
Route::get('/hiden_div',[SignupController::class,'hiden_div'])->name('hiden_div');



Route::get('/auth/google', [googlecontroller::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/google/callback', [googlecontroller::class, 'handleGoogleCallback']);


Route::get('/logout', [googlecontroller::class, 'logout'])->name('logout');

Route::get('/active-sessions', [SessionController::class, 'showSessions'])->name('active.sessions');


Route::get('/admin/page-visits', [PageVisitController::class, 'index'])->name('page-visits.index');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
