<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{
    public function send(Request $request)
{
    // Kirim email ke pengguna
    Mail::to($request->email)->send(new BookingNotification($request));

    return redirect()->route('index')->with('success', 'Email berhasil dikirim!');
}
}
