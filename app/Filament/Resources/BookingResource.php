<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                DatePicker::make('booking_date')
                    ->label('Tanggal Booking')
                    ->required(),
                TimePicker::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->required(),
                TimePicker::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->required(),
                TextInput::make('jumlah_orang')
                    ->label('Jumlah Orang')
                    ->numeric()
                    ->required(),
                TextInput::make('nama')
                    ->label('Nama')
                    ->required(),
                TextInput::make('nim')
                    ->label('NIM')
                    ->required(),
                TextInput::make('jurusan')
                    ->label('Jurusan')
                    ->required(),
                TextInput::make('email')
                    ->label('Email')
                    ->email()
                    ->required(),
                TextInput::make('no_telepon')
                    ->label('No Telepon')
                    ->required(),
                Textarea::make('alasan')
                    ->label('Alasan')
                    ->required(),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'approved' => 'Approved',
                        'pending' => 'Pending',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->afterStateUpdated(function ($state, $record) {
                        if ($state === 'rejected') {
                            // Logika tambahan jika diperlukan
                        }
                    }),
                Forms\Components\FileUpload::make('file')
                    ->label('File')
                    ->directory('uploads') // Simpan file di folder 'uploads'
                    ->acceptedFileTypes(['application/pdf']) // Hanya izinkan file PDF
                    ->maxSize(2048), // Maksimal ukuran file 2MB
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('booking_date')
                    ->label('Tanggal Booking')
                    ->date()
                    ->sortable(),
                TextColumn::make('waktu_mulai')
                    ->label('Waktu Mulai')
                    ->time(),
                TextColumn::make('waktu_selesai')
                    ->label('Waktu Selesai')
                    ->time(),
                TextColumn::make('nama')
                    ->label('Nama')
                    ->searchable(),
                TextColumn::make('jumlah_orang') // Tambahkan kolom ini
                    ->label('Jumlah Orang')
                    ->sortable(),
                TextColumn::make('room_type')
                    ->label('Tipe Ruangan')
                    ->formatStateUsing(function ($state) {
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
                        return $rooms[$state] ?? 'Tidak Diketahui';
                    }),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'approved',
                        'warning' => 'pending',
                        'danger' => 'rejected',
                    ]),
                TextColumn::make('file')
                    ->label('File')
                    ->formatStateUsing(function ($state) {
                        return $state ? '<a href="' . asset('storage/' . $state) . '" target="_blank">Lihat File</a>' : 'Tidak Ada File';
                    })
                    ->html(), // Pastikan kolom mendukung HTML
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
