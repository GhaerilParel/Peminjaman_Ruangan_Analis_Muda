<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\RoomController;

Route::get('/', [BookingController::class, 'create'])->name('index');

// Halaman yang bisa diakses tanpa login
Route::get('/index', [BookingController::class, 'create'])->name('index');
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::view('/mail', 'mail')->name('mail');

// Autentikasi
// Login dan logout untuk user biasa
Route::get('/login', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('register');
})->name('register')->middleware('guest');

Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// Halaman yang hanya bisa diakses jika sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/status-peminjaman', [BookingController::class, 'status'])->name('status.peminjaman');
});

Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store')->middleware('auth');
Route::get('/api/booked-dates', [BookingController::class, 'getBookedDates'])->name('booked.dates.by.room');

Route::get('/status-peminjaman', [BookingController::class, 'status'])->name('status.peminjaman');
Route::get('/booking/{booking}/edit', [BookingController::class, 'edit'])->name('booking.edit');
Route::put('/booking/{booking}', [BookingController::class, 'update'])->name('booking.update');
Route::put('/booking/{booking}/reject', [BookingController::class, 'reject'])->name('booking.reject');
Route::delete('/booking/{booking}', [BookingController::class, 'destroy'])->name('booking.destroy');

// Routes untuk aplikasi utama
Route::middleware(['auth:web'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
});

Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/api/rooms/recommendation', [RoomController::class, 'getRecommendations'])->name('api.rooms.recommendation');

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.process');