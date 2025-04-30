<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'room_type'     => 'required',
            'booking_date'  => 'required|date',
            'waktu_mulai'   => 'required|date_format:H:i|after_or_equal:06:00|before_or_equal:20:00',
            'waktu_selesai' => 'required|date_format:H:i|after:waktu_mulai|before_or_equal:20:00',
            'file' => 'nullable|mimes:pdf|max:2048', // Hanya file PDF dengan ukuran maksimal 2MB
        ]);

        // Simpan file jika ada
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('uploads', 'public');
        }

        // Validasi apakah waktu di hari yang sama sudah dibooking
        $isTimeConflict = Booking::where('room_type', $request->room_type)
            ->where('booking_date', $request->booking_date)
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
            'email'         => $request->email,
            'no_telepon'    => $request->telephone,
            'waktu_mulai'   => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'alasan'        => $request->review,
            'file'          => $filePath ?? null,
        ]);

        return redirect()->back()->with('success', 'Booking berhasil disimpan!');
    }

    // Controller untuk mendapatkan data tanggal yang dibooking berdasarkan ruangan
    public function getBookedDatesByRoom(Request $request)
    {
        $roomType = $request->query('room_type');

        $bookedDates = Booking::where('room_type', $roomType)
            ->select('booking_date', 'waktu_mulai', 'waktu_selesai', 'nama')
            ->get()
            ->groupBy('booking_date')
            ->map(function ($bookings, $date) {
                $totalBookedHours = $bookings->reduce(function ($carry, $booking) {
                    $start = Carbon::parse($booking->waktu_mulai);
                    $end = Carbon::parse($booking->waktu_selesai);
                    return $carry + $start->diffInHours($end);
                }, 0);

                $status = 'available'; // Default status
                if ($totalBookedHours >= 14) { // 14 jam (6 pagi - 8 malam)
                    $status = 'fully_booked';
                } elseif ($totalBookedHours > 0) {
                    $status = 'partially_booked';
                }

                return [
                    'booking_date' => $date,
                    'status' => $status,
                    'bookings' => $bookings->map(function ($booking) {
                        return [
                            'name' => $booking->nama,
                            'time' => $booking->waktu_mulai . ' - ' . $booking->waktu_selesai,
                        ];
                    }),
                ];
            })
            ->values();

        return response()->json($bookedDates);
    }
}

