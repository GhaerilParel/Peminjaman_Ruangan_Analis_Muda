<?php

namespace App\Mail;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     *
     * @param Booking $booking
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Ambil data ruangan berdasarkan ID dari database
        $room = Room::find($this->booking->room_type);

        return $this->subject('Status Booking Anda Telah Diperbarui')
                    ->view('emails.booking-status-updated')
                    ->with([
                        'nama' => $this->booking->nama,
                        'status' => $this->booking->status,
                        'booking_date' => $this->booking->booking_date,
                        'waktu_mulai' => $this->booking->waktu_mulai,
                        'waktu_selesai' => $this->booking->waktu_selesai,
                        'jumlah_orang' => $this->booking->jumlah_orang,
                        'room_type' => $room ? $room->name : 'Tidak Diketahui', // Ambil nama ruangan dari database
                        'alasan' => $this->booking->review, // Pastikan kolom pesan ada di database
                    ]);
    }
}
