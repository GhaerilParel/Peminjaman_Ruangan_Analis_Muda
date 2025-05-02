<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Booking;

class StatsOverview2 extends BaseWidget
{
    protected function getStats(): array
    {
        // Hitung jumlah booking dengan status "approved"
        $approvedCount = Booking::where('status', 'approved')->count();
        
        // Hitung jumlah booking dengan status "pending"
        $pendingCount = Booking::where('status', 'pending')->count();
        
        // Hitung jumlah booking dengan status "rejected"
        $rejectedCount = Booking::where('status', 'rejected')->count();

        return [
            // Statistik untuk booking yang disetujui
            Stat::make('Booking Disetujui', $approvedCount)
                ->description('Total booking yang disetujui')
                ->descriptionIcon('heroicon-m-check-circle') // Ikon untuk status "approved"
                ->color('success'), // Warna hijau untuk status "approved"

            // Statistik untuk booking yang masih pending
            Stat::make('Booking Pending', $pendingCount)
                ->description('Total booking yang masih pending')
                ->descriptionIcon('heroicon-m-clock') // Ikon untuk status "pending"
                ->color('warning'), // Warna kuning untuk status "pending"

            // Statistik untuk booking yang ditolak
            Stat::make('Booking Ditolak', $rejectedCount)
                ->description('Total booking yang ditolak')
                ->descriptionIcon('heroicon-m-x-circle') // Ikon untuk status "rejected"
                ->color('danger'), // Warna merah untuk status "rejected"
        ];
    }
}