<?php

use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return redirect()->route('logins');
});
use App\Http\Controllers\ChatController;
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
use App\Http\Controllers\contactcontroller;
use App\Http\Controllers\NoteController;

Route::get('/', function () {
    return view('welcome');
});
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
    Route::get('/logins', 'login')->name('logins');
    Route::post('/loginaction', 'loginactions')->name('loginaction');
});



// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', function () {
//         return view('dashbord');
//     })->name('dashboard');
// });




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




Route::controller(GoogleController::class)->group(function () { 
    Route::get('/auth/google', 'redirectToGoogle')->name('auth.google');
    Route::get('/dashboard', 'handleGoogleCallback')->name('auth.google.callback'); // Changed to /dashboard
    Route::post('/logout', 'logout')->name('logout');
});

// Route::get('/logout', [googlecontroller::class, 'logout'])->name('logout');

Route::get('/active-sessions', [SessionController::class, 'showSessions'])->name('active.sessions');


Route::get('/admin/page-visits', [PageVisitController::class, 'index'])->name('page-visits.index');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// genaral setting

Route::get('/genaral_setting', [App\Http\Controllers\genarelcontroller::class, 'index'])->name('general_setting');

Route::get('/connect', [App\Http\Controllers\connectedapplcontroller::class, 'index'])->name('connected_apps');


// contact controller
Route::controller(ContactController::class)->group(function () {
    Route::get('/contact', 'index')->name('contact');
    Route::post('/contact', 'ContactAction')->name('contact.store');
});


Route::middleware(['auth:web'])->group(function () {
    Route::get('/user-dashboard', function () {
        return view('notes.dashbord');
    })->name('dashboard');
});


Route::get('/note', [noteController::class, 'index'])->name('note.index');
Route::post('/note', [noteController::class, 'store'])->name('note.store');
Route::put('/notes/{id}', [noteController::class, 'update'])->name('note.update');
Route::delete('/notes/{id}', [noteController::class, 'destroy'])->name('note.destroy');
Route::patch('/notes/{id}/pin', [noteController::class, 'togglePin'])->name('note.pin');
Route::post('/notes/restore', [noteController::class, 'restore'])->name('note.restore');


Route::get('/chat', function () {
    return view('chatgpt');
});

Route::post('/chat', [ChatController::class, 'sendMessage']);