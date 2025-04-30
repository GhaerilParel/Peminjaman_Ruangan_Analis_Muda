@extends('partials.app')

@section('title', 'status')

@section('content')

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

@endsection
