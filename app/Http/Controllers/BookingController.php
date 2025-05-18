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
            'room_type' => 'required|exists:rooms,id', // Pastikan room_type ada di tabel rooms
            'booking_date' => 'required|date',
            'waktu_mulai' => 'required|date_format:H:i|after_or_equal:06:00|before_or_equal:20:00',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai|before_or_equal:20:00',
            'file' => 'nullable|mimes:pdf|max:2048',
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
        'room_type' => $request->room_type, // Simpan id ruangan yang dipilih
        'booking_date' => $request->booking_date,
        'jumlah_orang' => $request->jumlah_orang,
        'nama' => $request->firstname,
        'nim' => $request->nim,
        'jurusan' => $request->jurusan,
        'email' => auth()->user()->email,
        'no_telepon' => $request->telephone,
        'waktu_mulai' => $request->waktu_mulai,
        'waktu_selesai' => $request->waktu_selesai,
        'alasan' => $request->review,
        'file' => $request->file('file') ? $request->file('file')->store('uploads', 'public') : null,
        'status' => 'pending',
    ]);

    return redirect()->back()->with('success', 'Booking berhasil disimpan!');
    }

    // Controller untuk mendapatkan data tanggal yang dibooking berdasarkan ruangan
    public function getBookedDates(Request $request)
    {
        $roomType = $request->query('room_type'); // Ambil parameter room_type dari request

        // Ambil data booking dengan status approved
        $bookings = Booking::where('room_type', $roomType)
            ->where('status', 'approved')
            ->with('room') // Pastikan relasi room di-load
            ->select('booking_date', 'waktu_mulai', 'waktu_selesai', 'nama', 'room_type') // Tambahkan room_type
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
                        'room_name' => $booking->room->name ?? 'Unknown', // Ambil nama ruangan
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
        $rules = [
            'room_type' => 'required|exists:rooms,id', // Validasi ruangan harus ada di tabel rooms
            'booking_date' => 'required|date',
        ];

        // Hanya validasi waktu jika ada perubahan
        if (
            $request->waktu_mulai !== $booking->waktu_mulai ||
            $request->waktu_selesai !== $booking->waktu_selesai
        ) {
            $rules['waktu_mulai'] = 'required|date_format:H:i|after_or_equal:06:00|before_or_equal:20:00';
            $rules['waktu_selesai'] = 'required|date_format:H:i|after:waktu_mulai|before_or_equal:20:00';
        }

        $request->validate($rules);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
            $booking->file = $filePath;
        }

        // Validasi apakah waktu di hari yang sama sudah dibooking, hanya jika waktu berubah
        if (
            $request->waktu_mulai !== $booking->waktu_mulai ||
            $request->waktu_selesai !== $booking->waktu_selesai ||
            $request->booking_date !== $booking->booking_date ||
            $request->room_type !== $booking->room_type
        ) {
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
        }

        // Update data booking
        $booking->update([
            'room_type' => $request->room_type,
            'booking_date' => $request->booking_date,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'jumlah_orang' => $request->jumlah_orang,
            'nama' => $request->firstname,
            'nim' => $request->nim,
            'jurusan' => $request->jurusan,
            'email' => $request->email,
            'no_telepon' => $request->telephone,
            'alasan' => $request->review,
        ]);

        // Kirim email dengan data terbaru
        Mail::to($booking->email)->send(new BookingStatusUpdated($booking));

        // Redirect ke route status.peminjaman
        return redirect()->route('status.peminjaman')->with('success', 'Booking berhasil diperbarui!');
    }

    public function edit(Booking $booking)
    {
        $rooms = Room::all(); // Ambil semua data ruangan
        return view('edit', compact('booking', 'rooms')); // Kirim data booking dan rooms ke view
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
        return view('index', compact('rooms')); // Kirim data ke view
    }
}


