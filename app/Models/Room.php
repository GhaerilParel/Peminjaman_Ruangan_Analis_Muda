<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms'; // Nama tabel di database

    protected $fillable = [
        'name',
        'capacity',
        'description',
        'facility',
        'image', // Pastikan kolom image bisa diisi
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getFacilityAttribute($value)
    {
        return json_decode($value, true) ?? []; // Decode sebagai array, default ke array kosong jika null
    }

    public function setFacilityAttribute($value)
    {
        $this->attributes['facility'] = json_encode($value);
    }
}
