<?php

namespace App\Http\Controllers;

use App\Models\Room;

class AboutController extends Controller
{
    public function index()
    {
        // Ambil semua data ruangan dari database
        $rooms = Room::all();

        // Kirim data ke view 'about'
        return view('about', compact('rooms'));
    }
}
