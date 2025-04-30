{{-- filepath: c:\xampp\htdocs\Peminjaman-Ruangan\resources\views\booking\edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Edit Booking</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.update', $booking->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="room_type" class="form-label">Tipe Ruangan</label>
                <select name="room_type" id="room_type" class="form-select" required>
                    <option value="1" {{ $booking->room_type == 1 ? 'selected' : '' }}>CB Pemrograman</option>
                    <option value="2" {{ $booking->room_type == 2 ? 'selected' : '' }}>CB K70-1</option>
                    <option value="3" {{ $booking->room_type == 3 ? 'selected' : '' }}>CA RPL</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="booking_date" class="form-label">Tanggal Booking</label>
                <input type="date" name="booking_date" id="booking_date" class="form-control"
                    value="{{ $booking->booking_date }}" required>
            </div>

            <div class="mb-3">
                <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                <input type="time" name="waktu_mulai" id="waktu_mulai" class="form-control"
                    value="{{ $booking->waktu_mulai }}" required>
            </div>

            <div class="mb-3">
                <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                <input type="time" name="waktu_selesai" id="waktu_selesai" class="form-control"
                    value="{{ $booking->waktu_selesai }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_orang" class="form-label">Jumlah Orang</label>
                <input type="number" name="jumlah_orang" id="jumlah_orang" class="form-control"
                    value="{{ $booking->jumlah_orang }}" required>
            </div>

            <div class="mb-3">
                <label for="firstname" class="form-label">Nama</label>
                <input type="text" name="firstname" id="firstname" class="form-control"
                    value="{{ $booking->nama }}" required>
            </div>

            <div class="mb-3">
                <label for="nim" class="form-label">NIM</label>
                <input type="text" name="nim" id="nim" class="form-control" value="{{ $booking->nim }}" required>
            </div>

            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" name="jurusan" id="jurusan" class="form-control"
                    value="{{ $booking->jurusan }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ $booking->email }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="telephone" class="form-label">No Telepon</label>
                <input type="text" name="telephone" id="telephone" class="form-control"
                    value="{{ $booking->no_telepon }}" required>
            </div>

            <div class="mb-3">
                <label for="review" class="form-label">Alasan Peminjaman</label>
                <textarea name="review" id="review" class="form-control" rows="3" required>{{ $booking->alasan }}</textarea>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Surat Peminjaman (Opsional)</label>
                <input type="file" name="file" id="file" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>