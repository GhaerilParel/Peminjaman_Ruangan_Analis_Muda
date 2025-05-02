<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Booking;
use Carbon\Carbon;

class lineChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Peminjaman';

    protected function getData(): array
    {
        // Ambil data peminjaman dari database dan kelompokkan berdasarkan bulan
        $bookings = Booking::selectRaw('MONTH(booking_date) as month, COUNT(*) as total')
            ->whereYear('booking_date', Carbon::now()->year) // Hanya data tahun ini
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Format data untuk chart
        $data = array_fill(1, 12, 0); // Inisialisasi data untuk 12 bulan
        foreach ($bookings as $booking) {
            $data[$booking->month] = $booking->total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Peminjaman',
                    'data' => array_values($data), // Data jumlah peminjaman
                    'backgroundColor' => 'rgba(54, 163, 235, 0.07)', // Warna biru dengan transparansi
                    'borderColor' => 'rgba(54, 162, 235, 1)', // Warna biru solid untuk border
                    'borderWidth' => 1, // Ketebalan border
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}