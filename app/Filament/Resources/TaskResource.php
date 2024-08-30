<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource\RelationManagers;
use App\Models\Task;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class TaskResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canViewAny(): bool
    {
        if(Auth::check() && Auth::user()->role == User::ROLE_ADMIN ){
            return true;
        }
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')->disabled()
                    ->label('Progress Service')->helperText('(diupload servicer)')
                    ->disk('public') // Define the disk to use for storing files
                    ->directory('tasks'), // Specify the directory under the disk
                TextInput::make('title')
                    ->required()
                    ->label('Title')->placeholder("Laptop X441MA")->helperText('Isi nama barang yang di service'),
                Textarea::make('description')->required()
                    ->label('Description'),
                Select::make('karyawan_id')->helperText('tidak harus diisi')
                    ->label("Karyawan")->options(User::where('role', 'karyawan')->pluck('name', 'id')),
                Textarea::make('information_service')->disabled()
                        ->label('Informasi Service (diisi servicer)')->helperText('(diisi servicer)'),
                TextInput::make('client_name')->required()
                    ->label('Client Name'),
                TextInput::make('client_phone')->required()->type('number')
                    ->label('Client Phone'),
                TextInput::make('modal')->type('number')->default(0)
                    ->label('Modal Price (Rp)'),
                TextInput::make('price')->type('number')->default(0)
                    ->label('Service Price (Rp)'),
                Checkbox::make('isFinish')->default(false)->label("Status")
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label('Progress Service')
                    ->disk('public'),
                TextColumn::make('title')
                    ->label('Title')->searchable(),
                TextColumn::make('code')
                    ->label('Service Code')->searchable(),
                TextColumn::make('client_name')
                    ->label('Client Name')->searchable(),
                TextColumn::make('client_phone')
                    ->label('Client Phone')->searchable(),
                TextColumn::make('price')
                    ->label('Harga Service')
                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.') . ',-'),                
                TextColumn::make('karyawan_id')
                    ->label('Dikerjakan Oleh')
                    ->formatStateUsing(fn ($state) => User::find($state)?->name),
                BadgeColumn::make('isFinish')
                ->label('Status')
                ->colors([
                    'success' => fn ($state): bool => $state, // Hijau untuk selesai
                    'danger' => fn ($state): bool => !$state, // Merah untuk belum selesai
                ])
                ->icons([
                    'heroicon-o-check' => fn ($state): bool => $state, // Icon check untuk selesai
                    'heroicon-o-x-mark' => fn ($state): bool => !$state, // Icon X untuk belum selesai
                ])
                ->formatStateUsing(fn ($state) => $state ? 'Selesai' : 'Belum Selesai'),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->orderBy('created_at','desc'))
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);;
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
            'index' => Pages\ListTasks::route('/'),
            'create' => Pages\CreateTask::route('/create'),
            'edit' => Pages\EditTask::route('/{record}/edit'),
        ];
    }
}
