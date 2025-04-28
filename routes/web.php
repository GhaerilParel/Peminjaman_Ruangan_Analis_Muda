<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BookingController;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

Route::get('/', function () {
    return view('index');
})->name('index');


// Halaman yang bisa diakses tanpa login
Route::view('/index', 'index')->name('index');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
route::view('/mail', 'mail')->name('mail');

// Autentikasi
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->name('register.process');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman yang hanya bisa diakses jika sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
});

Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/api/booked-dates-by-room', [BookingController::class, 'getBookedDatesByRoom'])->name('booked.dates.by.room');

