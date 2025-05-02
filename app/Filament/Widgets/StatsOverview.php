<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Booking;
use App\Models\User;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Daftar kode ruangan dan nama ruangan
        $rooms = [
            1 => 'CB Pemrograman',
            2 => 'CB K70-1',
            3 => 'CA RPL',
            4 => 'CA KOM 1',
            5 => 'CA KOM 2',
            6 => 'CB Jaringan',
            7 => 'CB KOM 1',
            8 => 'CB KOM 2',
            9 => 'CB KOM 3',
            10 => 'CB KOM 4',
            11 => 'CB KOM 5',
        ];

        // Hitung jumlah total pengguna dari tabel users
        $totalUsers = User::count();

        // Hitung jumlah total peminjam dari tabel bookings
        $totalBorrowers = Booking::count();

        // Cari kode ruangan yang paling sering dipinjam
        $mostBookedRoomCode = Booking::select('room_type') // Ambil kolom room_type
            ->groupBy('room_type') // Kelompokkan berdasarkan room_type
            ->orderByRaw('COUNT(*) DESC') // Urutkan berdasarkan jumlah peminjaman terbanyak
            ->limit(1) // Ambil satu data teratas
            ->value('room_type'); // Ambil nilai room_type

        // Ambil nama ruangan berdasarkan kode ruangan
        $mostBookedRoomText = $rooms[$mostBookedRoomCode] ?? 'Tidak ada data'; // Jika tidak ada data, tampilkan "Tidak ada data"

        return [
            // Statistik untuk jumlah total pengguna
            Stat::make('Total Pengguna', $totalUsers)
                ->description('Jumlah total pengguna')
                ->descriptionIcon('heroicon-o-user-group') // Ikon untuk pengguna
                ->color('primary'), // Warna biru untuk statistik ini

            // Statistik untuk jumlah total peminjam
            Stat::make('Total Peminjam', $totalBorrowers)
                ->description('Jumlah total peminjam')
                ->descriptionIcon('heroicon-o-users') // Ikon untuk peminjam
                ->color('success'), // Warna hijau untuk statistik ini

            // Statistik untuk ruangan yang paling sering dipinjam
            Stat::make('Ruangan Terbanyak Dipinjam', $mostBookedRoomText)
                ->description('Nama ruangan yang paling sering dipinjam')
                ->descriptionIcon('heroicon-o-building-office'), // Ikon untuk ruangan
        ];
    }
}