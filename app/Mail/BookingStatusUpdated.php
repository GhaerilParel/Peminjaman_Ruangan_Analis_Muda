<?php

namespace App\Mail;

use App\Models\Booking;
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
        $roomTypes = [
            1 => 'CB Pemrograman',
            2 => 'CB K70-1',
            3 => 'CA RPL',
            4 => 'CA KOM 1',
            5 => 'CA KOM 2',
            6 => 'CB Jaringan',
            7 => 'CB KOM 1',
            8 => 'CB KOM 2',
            9 => 'CB KOM 3',
            10 => 'CB KOM 4',
            11 => 'CB KOM 5',
        ];

        return $this->subject('Status Booking Anda Telah Diperbarui')
                    ->view('emails.booking-status-updated')
                    ->with([
                        'nama' => $this->booking->nama,
                        'status' => $this->booking->status,
                        'booking_date' => $this->booking->booking_date,
                        'waktu_mulai' => $this->booking->waktu_mulai,
                        'waktu_selesai' => $this->booking->waktu_selesai,
                        'jumlah_orang' => $this->booking->jumlah_orang,
                        'room_type' => $roomTypes[$this->booking->room_type] ?? 'Tidak Diketahui',
                        'alasan' => $this->booking->review, // Pastikan kolom pesan ada di database
                    ]);
    }
}
