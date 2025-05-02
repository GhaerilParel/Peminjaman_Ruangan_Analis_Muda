<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;

class BarChart extends ChartWidget
{
    protected static ?string $heading = 'Jumlah Peminjam Per Ruangan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Daftar ruangan
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

        // Hitung jumlah peminjam per ruangan
        $data = [];
        foreach ($rooms as $key => $room) {
            $data[] = Booking::where('room_type', $key)->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjam',
                    'data' => $data,
                    'backgroundColor' => 'rgba(54, 163, 235, 0.07)', // Warna biru dengan transparansi
                    'borderColor' => 'rgba(54, 162, 235, 1)', // Warna biru solid untuk border
                    'borderWidth' => 1, // Ketebalan border
                ],
            ],
            'labels' => array_values($rooms),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}