@extends('partials.app')

@section('title', 'Edit Booking')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center py-4">
                <h3 class="mb-0 text-white">Edit Booking</h3>
            </div>
            <div class="card-body bg-light">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="updateForm" action="{{ route('booking.update', $booking->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-floating">
                        <select class="form-select required" id="room_type" name="room_type" aria-label="Room type">
                            <option value="" disabled>Pilih Ruangan</option>
                            @foreach ($rooms as $room)
                                <option value="{{ $room->id }}"
                                    {{ $booking->room_type == $room->id ? 'selected' : '' }}>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                        <label for="room_type">Ruangan</label>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="booking_date" class="form-label fw-bold">Tanggal Booking</label>
                            <input type="date" name="booking_date" id="booking_date" class="form-control"
                                value="{{ old('booking_date', $booking->booking_date) }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="jumlah_orang" class="form-label fw-bold">Jumlah Orang</label>
                            <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control"
                                value="{{ $booking->jumlah_orang }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="waktu_mulai" class="form-label fw-bold">Waktu Mulai</label>
                            <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control"
                                value="{{ old('waktu_mulai', $booking->waktu_mulai) }}" placeholder="HH:mm">
                        </div>

                        <div class="col-md-6 mb-4">
                            <label for="waktu_selesai" class="form-label fw-bold">Waktu Selesai</label>
                            <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control"
                                value="{{ old('waktu_selesai', $booking->waktu_selesai) }}" placeholder="HH:mm">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="firstname" class="form-label fw-bold">Nama</label>
                        <input type="text" name="firstname" id="firstname" class="form-control"
                            value="{{ $booking->nama }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="nim" class="form-label fw-bold">NIM</label>
                            <input type="text" name="nim" id="nim" class="form-control"
                                value="{{ $booking->nim }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="jurusan" class="form-label fw-bold">Jurusan</label>
                            <input type="text" name="jurusan" id="jurusan" class="form-control"
                                value="{{ $booking->jurusan }}" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="email" class="form-label fw-bold">Email</label>
                        <input type="email" name="email" id="email" class="form-control"
                            value="{{ $booking->email }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="telephone" class="form-label fw-bold">No Telepon</label>
                        <input type="text" name="telephone" id="telephone" class="form-control"
                            value="{{ $booking->no_telepon }}" required>
                    </div>

                    <div class="mb-4">
                        <label for="review" class="form-label fw-bold">Alasan Peminjaman</label>
                        <textarea name="review" id="review" class="form-control" rows="3" required>{{ $booking->alasan }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-bold">Surat Peminjaman (Opsional)</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                </form>

                <div class="d-flex justify-content-between mt-4">
                    <!-- Reject Form -->
                    <form action="{{ route('booking.reject', $booking->id) }}" method="POST"
                        onsubmit="return confirm('Apakah Anda yakin ingin menolak booking ini?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-danger btn-lg px-5">
                            <i class="fas fa-trash-alt"></i> Hapus Booking
                        </button>
                    </form>

                    <!-- Update Form -->
                    <button type="submit" form="updateForm" class="btn btn-primary btn-lg px-5">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
