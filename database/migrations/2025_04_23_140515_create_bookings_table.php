<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('room_type');
            $table->date('booking_date');
            $table->integer('jumlah_orang');
            $table->string('nama');
            $table->string('nim');
            $table->string('jurusan');
            $table->string('email');
            $table->string('no_telepon');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->text('alasan');
            $table->string('file')->nullable();
            $table->enum('status', ['booked', 'canceled'])->default('booked');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
