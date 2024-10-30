<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkupinaController;
use App\Http\Controllers\PrispevekController;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    // Dashboard routa
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');




    // Přihlášení do skupiny
    Route::get('/skupiny/prihlasit', function () {
        return view('skupiny.prihlasit-se');
    })->name('skupiny.prihlasit-se');

    Route::post('/skupiny/prihlasit', [SkupinaController::class, 'prihlasit'])->name('skupiny.prihlasit');

    // Přihlášení pomocí pozvánky
    Route::post('/skupiny/prihlasit/pozvankou', [SkupinaController::class, 'prihlasitPomociPozvanky'])->name('skupiny.prihlasit_pozvankou');
    // Pozvánky routy
    Route::get('/skupiny/{id}/pozvanky', [SkupinaController::class, 'zobrazPozvanky'])->name('pozvanky.index');
    Route::post('/skupiny/{id}/pozvanky', [SkupinaController::class, 'vytvoritPozvanku'])->name('pozvanky.vytvorit');
    Route::delete('pozvanky/{id}', [SkupinaController::class, 'smazatPozvanku'])->name('pozvanky.smazat');

    // Admin panel pro pozvánky
    Route::get('/skupiny/{id}/admin', [SkupinaController::class, 'zobrazAdminPanel'])->name('pozvanky.admin');

    // Příspěvky routy
    Route::get('/prispevky/create', [PrispevekController::class, 'create'])->name('prispevky.create');
    Route::post('/prispevky', [PrispevekController::class, 'store'])->name('prispevky.store');
    Route::get('prispevky/{id}', [PrispevekController::class, 'detail'])->name('prispevky.detail');
    Route::delete('prispevky/{prispevek}', [PrispevekController::class, 'destroy'])->name('prispevky.destroy');
    Route::post('/prispevky/{id}/komentar', [PrispevekController::class, 'ulozitKomentar'])->name('prispevky.komentar');


    // Skupiny routy
    Route::get('/skupiny', [SkupinaController::class, 'index'])->name('skupiny.index');
    Route::get('/skupiny/create', [SkupinaController::class, 'create'])->name('skupiny.create');
    Route::post('/skupiny', [SkupinaController::class, 'store'])->name('skupiny.store');


    Route::get('/skupiny/mojeSkupiny', [SkupinaController::class, 'mojeSkupiny'])
        ->name('skupiny.moje')
        ->middleware('auth');

    Route::get('/skupiny/{id}', [SkupinaController::class, 'show'])->name('skupiny.show');
    Route::delete('skupiny/{skupina}', [SkupinaController::class, 'destroy'])->name('skupiny.destroy');
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



