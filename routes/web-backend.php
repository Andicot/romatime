<?php

use Illuminate\Support\Facades\Route;


Route::get('/', [\App\Http\Controllers\Backend\DashboardController::class, 'show']);

Route::resource('orologio', \App\Http\Controllers\Backend\OrologioController::class);

Route::resource('orologio/{orologioId}/vendita', \App\Http\Controllers\Backend\VenditaController::class)->except(['show']);

//select2
Route::get('select2', [\App\Http\Controllers\Backend\Select2::class, 'response']);

//Allegati
Route::get('/allegato/{id}', [\App\Http\Controllers\Backend\AllegatoController::class, 'downloadAllegato']);
Route::post('/allegato', [\App\Http\Controllers\Backend\AllegatoController::class, 'uploadAllegato']);
Route::delete('/allegato', [\App\Http\Controllers\Backend\AllegatoController::class, 'deleteAllegato']);
Route::get('/allegato/{id}/show', [\App\Http\Controllers\Backend\AllegatoController::class, 'showAllegato']);

//Registri
Route::get('registro/{cosa}', [\App\Http\Controllers\Backend\RegistriController::class, 'index']);

//Dati utente
Route::get('/dati-utente', [\App\Http\Controllers\Backend\DatiUtenteController::class, 'show']);
Route::patch('/dati-utente/{cosa}', [\App\Http\Controllers\Backend\DatiUtenteController::class, 'update']);

//Tabelle
Route::resource('marca', \App\Http\Controllers\Backend\MarcaController::class)->except('show');
