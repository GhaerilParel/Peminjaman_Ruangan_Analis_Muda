<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingStatusUpdated;
use Illuminate\Database\Eloquent\Builder;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_type',
        'booking_date',
        'jumlah_orang',
        'nama',
        'nim',
        'jurusan',
        'email',
        'no_telepon',
        'waktu_mulai',
        'waktu_selesai',
        'alasan',
        'file',
        'status',
    ];   
    
    public static function boot()
    {
        parent::boot();

        static::updated(function ($booking) {
            // Jika status diubah menjadi "rejected"
            if ($booking->status === 'rejected') {
                // Logika untuk membuat tanggal tersedia kembali
                // (Tidak perlu tindakan tambahan karena hanya status yang diperiksa)
            }
        });

        static::saving(function ($booking) {
            // Validasi hanya jika status adalah 'approved'
            if ($booking->status === 'approved') {
                $conflict = self::query()
                    ->where('room_type', $booking->room_type)
                    ->where('booking_date', $booking->booking_date)
                    ->where('status', 'approved') // Hanya periksa jadwal dengan status approved
                    ->where(function (Builder $query) use ($booking) {
                        $query->whereBetween('waktu_mulai', [$booking->waktu_mulai, $booking->waktu_selesai])
                              ->orWhereBetween('waktu_selesai', [$booking->waktu_mulai, $booking->waktu_selesai])
                              ->orWhere(function (Builder $subQuery) use ($booking) {
                                  $subQuery->where('waktu_mulai', '<=', $booking->waktu_mulai)
                                           ->where('waktu_selesai', '>=', $booking->waktu_selesai);
                              });
                    })
                    ->exists();

                if ($conflict) {
                    throw new \Exception('Jadwal sudah di-booking pada tanggal, jam, dan ruangan yang sama.');
                }
            }
        });
    }

    protected static function booted()
    {
        static::saved(function ($booking) {
            // Kirim email setelah data disimpan
            if ($booking->wasChanged('status')) { // Hanya kirim email jika status berubah
                Mail::to($booking->email)->send(new BookingStatusUpdated($booking));
            }
        });
        
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
        return $this->belongsTo(Room::class, 'room_type');
    }

}
