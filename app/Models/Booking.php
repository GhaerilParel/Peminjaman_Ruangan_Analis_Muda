<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'status'  // Menambahkan 'status' ke dalam field yang dapat diisi
    ];   
    
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
