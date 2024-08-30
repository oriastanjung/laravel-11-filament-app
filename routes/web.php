<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Middleware\RoleMiddleware;
Route::get('/', function () {
    return view('welcome');
});


Route::middleware([RoleMiddleware::class . ':' . User::ROLE_ADMIN])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});