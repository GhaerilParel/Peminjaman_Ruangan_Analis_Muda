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
        'status',
    ];   
    
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
        return $this->belongsTo(Room::class, 'room_type');
    }

}
