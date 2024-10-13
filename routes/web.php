<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkupinaController;


Route::get('/skupiny', [SkupinaController::class, 'index'])->name('skupiny.index');

// Route pro zobrazení formuláře pro vytvoření skupiny
Route::get('/skupiny/create', [SkupinaController::class, 'create'])->name('skupiny.create');

// Route pro zobrazení detailu skupiny
Route::get('/skupiny/{id}', [SkupinaController::class, 'show'])->name('skupiny.show');

Route::post('/skupiny', [SkupinaController::class, 'store'])->name('skupiny.store');

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
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/zkouska', function () {
        return view('zkouska');
    })->name('zkouska');
});
