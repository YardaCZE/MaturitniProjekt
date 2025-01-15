<?php

use App\Http\Controllers\ZavodyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/ulozit-data', [ZavodyController::class, 'ulozitData']);
