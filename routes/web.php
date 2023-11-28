<?php

use Illuminate\Support\Facades\Route;
use App\Events\NewTaskEmailEvent;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/new-task', function () {
        return view('new-task');
    })->name('new-task');
});

Livewire::setUpdateRoute(function ($handle) {
    return Route::post('/tasks-app/public/livewire/update', $handle);
    });

Livewire::setScriptRoute(function ($handle) {
    return Route::get('/tasks-app/public/livewire/livewire.js', $handle);
    });