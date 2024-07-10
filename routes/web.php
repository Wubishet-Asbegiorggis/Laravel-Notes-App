<?php

use App\Http\Controllers\NotesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

//Route::get('notes/{note}', [NotesController::class, 'show']);

Route::middleware(['auth'])->group(function () {
    Route::resource('notes', NotesController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
