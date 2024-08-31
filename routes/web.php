<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Task;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware([RoleMiddleware::class . ':' . User::ROLE_ADMIN])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    });
});

Route::get('/cek-task/{code}',function ($code){
    $data_task = Task::where('code',$code)->first();
    return response()->json([
        'message' => 'success',
        'data' => $data_task
    ]);
});


Route::get('/tasks/{task}/print', function (Task $task) {
    return view('notatask', compact('task'));
})->name('tasks.print');