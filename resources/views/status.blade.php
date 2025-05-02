@extends('partials.app')

@section('title', 'Status')

@section('content')

    <div class="container mt-5">
        <h4 class="text-center mb-4 text-primary">Status Peminjaman</h4>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded" role="alert">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($bookings->isEmpty())
            <div class="alert alert-info text-center shadow-sm rounded">
                <i class="fas fa-info-circle"></i> Tidak ada data peminjaman.
            </div>
        @else
            <div class="table-container overflow-x-auto border rounded-lg bg-white shadow-sm">
                <table class="min-w-full text-left text-sm font-sans">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2">#</th>
                            <th class="px-4 py-2">Tanggal Booking</th>
                            <th class="px-4 py-2">Waktu Mulai</th>
                            <th class="px-4 py-2">Waktu Selesai</th>
                            <th class="px-4 py-2">Nama</th>
                            <th class="px-4 py-2">Tipe Ruangan</th>
                            <th class="px-4 py-2">Status</th>
                            <th class="px-4 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($bookings as $index => $booking)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $booking->booking_date }}</td>
                                <td class="px-4 py-2">{{ $booking->waktu_mulai }}</td>
                                <td class="px-4 py-2">{{ $booking->waktu_selesai }}</td>
                                <td class="px-4 py-2">{{ $booking->nama }}</td>
                                <td class="px-4 py-2">{{ $booking->room_type }}</td>
                                <td class="px-4 py-2">
                                    @if ($booking->status === 'approved')
                                        <span
                                            class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $booking->status }}
                                        </span>
                                    @elseif ($booking->status === 'rejected')
                                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $booking->status }}
                                        </span>
                                    @else
                                        <span
                                            class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-medium">
                                            {{ $booking->status }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('booking.edit', $booking->id) }}"
                                        class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-medium hover:bg-blue-200">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

@endsection
