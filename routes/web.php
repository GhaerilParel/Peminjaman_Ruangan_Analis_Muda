<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RoomController;

// Halaman utama
Route::get('/', [BookingController::class, 'create'])->name('index');
Route::get('/index', [BookingController::class, 'create'])->name('index');

// Halaman publik (tanpa login)
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/mail', 'mail')->name('mail');

// Autentikasi
Route::middleware('guest')->group(function () {
    Route::get('/login', fn () => view('login'))->name('login');
    Route::get('/register', fn () => view('register'))->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Booking - hanya bisa diakses setelah login
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/status-peminjaman', [BookingController::class, 'status'])->name('status.peminjaman');
    Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('booking.update');
    Route::put('/booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');
    Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');
});

// API
Route::get('/api/booked-dates', [BookingController::class, 'getBookedDates'])->name('booked.dates.by.room');
Route::get('/api/rooms/recommendation', [RoomController::class, 'recommendation'])->name('api.rooms.recommendation');

// Halaman about dengan controller
Route::get('/about', [AboutController::class, 'index'])->name('about');
