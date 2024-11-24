<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LokalityController;
use App\Http\Controllers\UlovkyController;
use App\Http\Controllers\ZavodyController;
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
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');




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
    Route::post('/skupiny/{skupina}/pripojit', [SkupinaController::class, 'pripojit'])->name('skupiny.pripojit');

    // Admin panel
    Route::get('/skupiny/{id}/admin', [SkupinaController::class, 'AdminPanel'])->name('pozvanky.admin');
    Route::post('/skupiny/{idSkupiny}/admin/{idUzivatele}/pridat', [SkupinaController::class, 'pridatModeratora'])->name('moderatori.pridat');
    Route::delete('/skupiny/{idSkupiny}/admin/{idUzivatele}/odebrat', [SkupinaController::class, 'odebratModeratora'])->name('moderatori.odebrat');
    Route::delete('/skupiny/{skupina}/clenove/{clen}', [SkupinaController::class, 'smazatClena'])->name('cleni.smazat');

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
    Route::get('/lokality/skupina/{skupina_id}', [LokalityController::class, 'soukromeLokality'])
        ->name('lokality.skupinaLokality');

    Route::get('/ulovky/skupina/{skupina_id}', [UlovkyController::class, 'soukromeUlovky'])
        ->name('ulovky.SkupinaUlovky');



    Route::get('/skupiny/{id}', [SkupinaController::class, 'show'])->name('skupiny.show');
    Route::delete('skupiny/{skupina}', [SkupinaController::class, 'destroy'])->name('skupiny.destroy');


    // lokality
    Route::get('/lokality', [LokalityController::class, 'index'])->name('lokality.index');
    Route::get('/lokality/vytvorit', [LokalityController::class, 'create'])->name('lokality.create');
    Route::post('/lokality', [LokalityController::class, 'store'])->name('lokality.store');
    Route::post('/lokality/{id}/nahrat-obrazek', [LokalityController::class, 'nahratObrazek'])
        ->name('lokality.nahratObrazek');
    Route::get('/lokality/{id}', [LokalityController::class, 'detail'])->name('lokality.detail');
    Route::post('/lokality/{id}/like', [LokalityController::class, 'like'])->name('lokality.like');
    Route::post('/lokality/{id}/save', [LokalityController::class, 'save'])->name('lokality.save');

    Route::delete('/lokality/{lokalita}', [LokalityController::class, 'destroy'])->name('lokality.destroy');

    //ulovkz
    Route::get('/ulovky', [UlovkyController::class, 'index'])->name('ulovky.index');
    Route::get('/ulovky/create', [UlovkyController::class, 'create'])->name('ulovky.create');
    Route::post('/ulovky', [UlovkyController::class, 'store'])->name('ulovky.store');
    Route::post('/ulovky/{ulovek}/komentar', [UlovkyController::class, 'ulozitKomentar'])->name('ulovky.komentar');
    Route::post('/ulovky/{id}/save', [UlovkyController::class, 'save'])->name('ulovky.save');

    Route::post('/ulovky/{id}/like', [UlovkyController::class, 'like'])->name('ulovky.like');

    Route::get('/ulovky/{id}', [UlovkyController::class, 'detail'])->name('ulovky.detail');
    Route::delete('/ulovky/{id}', [UlovkyController::class, 'destroy'])->name('ulovky.destroy');


    Route::get('/ulozene', [Controller::class, 'ulozene'])->name('ulozene');


    //zavody
    Route::get('/zavody/', [ZavodyController::class, 'index'])->name('zavody.index');
    Route::get('/zavody/create', [ZavodyController::class, 'create'])->name('zavody.create');
    Route::post('/zavody', [ZavodyController::class, 'store'])->name('zavody.store');
    Route::get('/zavody/{id}', [ZavodyController::class, 'detail'])->name('zavody.detail');
    Route::get('/zavody/{id}/pridatZavodnika', [ZavodyController::class, 'pridatZavodnika'])->name('zavody.pridatZavodnika');
    Route::post('/zavody/{id}/zavodnik', [ZavodyController::class, 'storeZavodnik'])->name('zavody.storeZavodnik');

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



