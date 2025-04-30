{{-- filepath: c:\xampp\htdocs\Peminjaman-Ruangan\resources\views\status.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Status Peminjaman</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($bookings->isEmpty())
            <div class="alert alert-info text-center">
                Tidak ada data peminjaman.
            </div>
        @else
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Tanggal Booking</th>
                        <th>Waktu Mulai</th>
                        <th>Waktu Selesai</th>
                        <th>Nama</th>
                        <th>Tipe Ruangan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $index => $booking)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $booking->booking_date }}</td>
                            <td>{{ $booking->waktu_mulai }}</td>
                            <td>{{ $booking->waktu_selesai }}</td>
                            <td>{{ $booking->nama }}</td>
                            <td>{{ $booking->room_type }}</td>
                            <td>{{ $booking->status }}</td>
                            <td>
                                <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</body>

</html>