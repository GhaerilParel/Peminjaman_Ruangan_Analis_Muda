<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Room; // Tambahkan model Room di bagian atas
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusUpdated;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_type'     => 'required',
            'booking_date'  => 'required|date',
            'waktu_mulai'   => 'required|date_format:H:i|after_or_equal:06:00|before_or_equal:20:00',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai|before_or_equal:20:00',
            'file'          => 'nullable|mimes:pdf|max:2048',
        ]);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        // Validasi apakah waktu di hari yang sama sudah dibooking
        $isTimeConflict = Booking::where('room_type', $request->room_type)
            ->where('booking_date', $request->booking_date)
            ->where('status', 'approved') // Hanya booking dengan status approved
            ->where(function ($query) use ($request) {
                $query->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
            })
            ->exists();

        if ($isTimeConflict) {
            return redirect()->back()->withErrors(['error' => 'Waktu yang dipilih sudah dibooking pada tanggal tersebut.']);
        }

        // Simpan data booking
        Booking::create([
            'room_type'     => $request->room_type,
            'booking_date'  => $request->booking_date,
            'jumlah_orang'  => $request->jumlah_orang,
            'nama'          => $request->firstname,
            'nim'           => $request->nim,
            'jurusan'       => $request->jurusan,
            'email'         => auth()->user()->email, // Gunakan email pengguna yang login
            'no_telepon'    => $request->telephone,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'alasan'        => $request->review,
            'file'          => $filePath ?? null,
            'status'        => 'pending',
        ]);

        return redirect()->back()->with('success', 'Booking berhasil disimpan!');
    }

    // Controller untuk mendapatkan data tanggal yang dibooking berdasarkan ruangan
    public function getBookedDates(Request $request)
    {
        $roomType = $request->query('room_type'); // Ambil parameter room_type dari request

        // Ambil data booking dengan status approved
        $bookings = Booking::where('room_type', $roomType)
            ->where('status', 'approved') // Hanya ambil booking dengan status approved
            ->select('booking_date', 'waktu_mulai', 'waktu_selesai', 'nama') // Pilih kolom yang diperlukan
            ->get();

        // Format data untuk dikirim ke frontend
        $formattedBookings = $bookings->groupBy('booking_date')->map(function ($bookingsOnDate) {
            return [
                'date' => $bookingsOnDate->first()->booking_date,
                'status' => 'approved',
                'bookings' => $bookingsOnDate->map(function ($booking) {
                    return [
                        'nama' => $booking->nama,
                        'waktu_mulai' => $booking->waktu_mulai,
                        'waktu_selesai' => $booking->waktu_selesai,
                    ];
                })->toArray(),
            ];
        })->values();

        return response()->json($formattedBookings);
    }

    public function status()
    {
        $bookings = Booking::where('email', auth()->user()->email)->get(); // Filter berdasarkan email pengguna yang login
        return view('status', compact('bookings'));
    }

    public function update(Request $request, Booking $booking)
    {
        $request->validate([
            'room_type'     => 'required',
            'booking_date'  => 'required|date',
            'waktu_mulai'   => 'required|date_format:H:i|after_or_equal:06:00|before_or_equal:20:00',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai|before_or_equal:20:00',
            'file'          => 'nullable|mimes:pdf|max:2048',
        ]);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $booking->file = $filePath;
        }

        // Validasi apakah waktu di hari yang sama sudah dibooking
        $isTimeConflict = Booking::where('room_type', $request->room_type)
            ->where('booking_date', $request->booking_date)
            ->where('status', 'approved') // Hanya booking dengan status approved
            ->where('id', '!=', $booking->id) // Abaikan booking yang sedang diedit
            ->where(function ($query) use ($request) {
                $query->where('waktu_mulai', '<', $request->waktu_selesai)
                      ->where('waktu_selesai', '>', $request->waktu_mulai);
            })
            ->exists();

        if ($isTimeConflict) {
            return redirect()->back()->withErrors(['error' => 'Waktu yang dipilih sudah dibooking pada tanggal tersebut.']);
        }

        // Update data booking
        $booking->update([
            'room_type'     => $request->room_type,
            'booking_date'  => $request->booking_date,
            'jumlah_orang'  => $request->jumlah_orang,
            'nama'          => $request->firstname,
            'nim'           => $request->nim,
            'jurusan'       => $request->jurusan,
            'email'         => $request->email,
            'no_telepon'    => $request->telephone,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'alasan'        => $request->review,
            'status'        => 'pending', // Set status menjadi pending setelah pengeditan
        ]);

        // Ambil data terbaru dari database
        $booking = Booking::find($booking->id);

        // Kirim email dengan data terbaru
        Mail::to($booking->email)->send(new BookingStatusUpdated($booking));

        // Redirect ke route status.peminjaman
        return redirect()->route('status.peminjaman')->with('success', 'Booking berhasil diperbarui!');
        dd($request->all()); // Debug the incoming request data
    }

    public function edit(Booking $booking)
    {
        return view('edit', compact('booking')); // Arahkan ke view edit
    }

    public function reject(Booking $booking)
    {
        $booking->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('status.peminjaman')->with('success', 'Booking berhasil dihapus (status: rejected)!');
    }

    public function create()
    {
        $rooms = Room::all(); // Ambil semua data ruangan
        return view('booking.create', compact('rooms')); // Kirim data ke view
    }
}


