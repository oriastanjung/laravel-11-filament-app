<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaskKaryawanResource\Pages;
use App\Filament\Resources\TaskKaryawanResource\RelationManagers;
use App\Models\Task;
use App\Models\User;
// use App\Models\TaskKaryawan;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TaskKaryawanResource extends Resource
{
    protected static ?string $model = Task::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';

    public static function canViewAny(): bool
    {
        if(Auth::check() && Auth::user()->role == User::ROLE_KARYAWAN ){
            return true;
        }
        return false;
    }
    public static function canCreate(): bool
    {
        return false;
    }
    public static function canEdit(Model $record): bool
    {
        return false;
    }
    
    public static function canDelete(Model $record): bool
    {
        
        return false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('image')->required()
                    ->label('Progress Service')->helperText('(diupload servicer)')
                    ->disk('public') // Define the disk to use for storing files
                    ->directory('tasks')
                    ->deleteUploadedFileUsing(fn ($file) => Storage::disk('public')->delete($file)), // Specify the directory under the disk
                TextInput::make('code')
                    ->disabled()
                    ->label('Service Code')->helperText('akan digenerate otomatis'),
                TextInput::make('title')->disabled()
                    ->required()
                    ->label('Title')->placeholder("Laptop X441MA")->helperText('Isi nama barang yang di service'),
                Textarea::make('description')->required()->disabled()
                    ->label('Description'),
                Select::make('karyawan_id')->disabled()
                    ->label("Karyawan")->options(User::where('role', 'karyawan')->pluck('name', 'id')),
                Textarea::make('information_service')->required()
                        ->label('Informasi Service (diisi servicer)')->helperText('(diisi servicer)'),
                TextInput::make('client_name')->required()->disabled()
                    ->label('Client Name'),
                TextInput::make('client_phone')->required()->type('number')->disabled()
                    ->label('Client Phone'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // ImageColumn::make('image')
                //     ->label('Progress Service')
                //     ->disk('public'),
                TextColumn::make('title')
                    ->label('Title')->searchable(),
                TextColumn::make('description')
                    ->label('Description')->searchable()
                    ->wrap() // Ini agar teks secara otomatis membungkus
                    ->extraAttributes(['style' => 'max-width: 200px; word-wrap: break-word; white-space: normal;'])
                    ->formatStateUsing(function ($state) {
                        // Membatasi jumlah kata yang ditampilkan
                        $words = explode(' ', $state);
                        return implode(' ', array_slice($words, 0, 12)) . (count($words) > 12 ? '...' : '');
                    }),
                TextColumn::make('code')
                    ->label('Service Code')->searchable(),
                TextColumn::make('client_name')
                    ->label('Client Name')->searchable(),
                // TextColumn::make('client_phone')
                //     ->label('Client Phone')->searchable(),           
                // TextColumn::make('karyawan_id')
                //     ->label('Dikerjakan Oleh')
                //     ->formatStateUsing(fn ($state) => User::find($state)?->name),
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
            ->modifyQueryUsing(fn (Builder $query) => $query->where('karyawan_id','=',null)->orderBy('updated_at','desc'))
            ->actions([
                Tables\Actions\Action::make('assignKaryawan')
                    ->label('Assign to Me')
                    ->icon('heroicon-o-check')
                    ->action(function (Task $record) {
                        $record->karyawan_id = Auth::user()->id;
                        $record->save();
                    })
                    ->hidden(fn (Task $record) => $record->karyawan_id === Auth::user()->id), // Sembunyikan jika sudah diassign
            ])
            
            // ->defaultSort('created_at', 'desc')
            ;
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
            'index' => Pages\ListTaskKaryawans::route('/'),
            'create' => Pages\CreateTaskKaryawan::route('/create'),
            'edit' => Pages\EditTaskKaryawan::route('/{record}/edit'),
        ];
    }
}
