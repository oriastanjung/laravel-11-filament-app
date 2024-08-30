<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'karyawan_id',
        'information_service',
        'client_name',
        'client_phone',
        'code',
        'price',
        'modal',
        'isFinish'
    ];
    protected static function booted()
    {
        static::creating(function ($task) {
            // Automatically set karyawan_id to the currently authenticated user's ID
            // $task->karyawan_id = Auth::id();

            // Generate a unique 16-character alphanumeric code
            $task->code = Str::random(16);
        });

        static::deleting(function ($task) {
            if ($task->image) {
                Storage::disk('public')->delete($task->image);
            }
        });
    }
}
