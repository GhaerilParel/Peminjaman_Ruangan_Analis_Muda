<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoomResource\Pages;
use App\Models\Room;
use Filament\Forms;  // Menggunakan Forms namespace
use Filament\Forms\Form;  // Ini yang benar
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\CheckboxList;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ImageColumn;

class RoomResource extends Resource
{
    protected static ?string $model = Room::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Ruangan'; // Optional: Adding navigation label
    protected static ?string $navigationGroup = 'Pengelolaan Ruangan'; // Optional: Adding navigation group

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->label('Nama Ruangan'),
                TextInput::make('capacity')
                    ->required()
                    ->numeric()
                    ->label('Kapasitas'),
                Textarea::make('description')
                    ->nullable()
                    ->label('Deskripsi'),
                CheckboxList::make('facility')
                    ->label('Fasilitas Ruangan')
                    ->options([
                        'Komputer' => 'Komputer',
                        'Proyektor' => 'Proyektor',
                        'Wifi' => 'Wifi',
                        'AC' => 'AC',
                        'Microfon' => 'Mikrofon',
                    ])
                    ->columns(2) // Menampilkan checkbox dalam 2 kolom
                    ->required(),
                FileUpload::make('image') // Tambahkan komponen untuk upload gambar
                    ->image()
                    ->directory('uploads/rooms') // Direktori penyimpanan
                    ->label('Gambar Ruangan')
                    ->visibility('public') // Pastikan file dapat diakses secara publik
                    ->getUploadedFileNameForStorageUsing(fn ($file) => $file->hashName()), // Gunakan nama file yang di-hash
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image') // Kolom untuk menampilkan gambar
                    ->label('Gambar')
                    ->size(50) // Ukuran gambar
                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/' . $record->image) : null),
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Ruangan'),
                Tables\Columns\TextColumn::make('capacity')
                    ->sortable()
                    ->label('Kapasitas'),
                Tables\Columns\TextColumn::make('description')
                    ->limit(50)
                    ->label('Deskripsi'),
                Tables\Columns\TextColumn::make('facility')
                    ->limit(50)
                    ->label('Fasilitas')
                    ->getStateUsing(function ($record) {
                        // Debug tipe data
                        if (!is_array($record->facility)) {
                            \Log::info('Facility is not an array: ' . $record->facility);
                        }
                        return $record->facility ? implode(', ', is_array($record->facility) ? $record->facility : json_decode($record->facility, true)) : '-';
                    }),
            ])
            ->filters([
                // Add your filters here if necessary
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add relation managers if necessary
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRooms::route('/'),
            'create' => Pages\CreateRoom::route('/create'),
            'edit' => Pages\EditRoom::route('/{record}/edit'),
        ];
    }
}
