<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function store(Request $request)
    {


        // Validasi input
        $validated = $request->validate([
            'room_type' => 'required|string|max:100',
            'booking_date' => 'required|date_format:Y-m-d',
            'jumlah_orang' => 'required|integer',
            'firstname' => 'required|string|max:255',
            'nim' => 'required|string|max:50',
            'jurusan' => 'required|string|max:100',
            'email' => 'required|email',
            'telephone' => 'required|string|max:20',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'review' => 'required|string',
            'file' => 'nullable|file',
        ]);

        // Simpan file jika ada
        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('surat', 'public');
        }

        // Simpan data booking ke database

        Booking::create([
            'room_type'     => $request->room_type,
            'booking_date' => $request->booking_date,  // ambil dari hidden input
            'jumlah_orang'  => $request->jumlah_orang,   // ambil dari input number
            'nama' => $request->firstname,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'email' => $request->email,
            'no_telepon' => $request->telephone,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'alasan' => $request->review,
            'file'          => $filePath,                // jangan $file_name
        ]);

        return redirect()->back()->with('success', 'Booking berhasil disimpan!');
    }

// Controller untuk mendapatkan data tanggal yang dibooking berdasarkan ruangan
public function getBookedDatesByRoom()
{
    $bookedDates = Booking::select('room_type', 'booking_date', 'status')
                          ->where('status', 'booked') // Hanya ambil data dengan status 'booked'
                          ->get()
                          ->map(function ($item) {
                              $item->booking_date = \Carbon\Carbon::parse($item->booking_date)->format('Y-m-d');
                              return $item;
                          });

    return response()->json($bookedDates);
}
}

