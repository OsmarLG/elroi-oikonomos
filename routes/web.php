<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'landing.home')->name('landing');

Route::get('/login', function () {
    return redirect()->route('filament.admin.auth.login');
})->name('login');

Route::get('/register', function () {
    return redirect()->route('filament.admin.auth.register');
})->name('register');

Route::middleware(['auth'])->group(function () {
    Route::get('/notes/{note}/edit', \App\Livewire\SingleNoteEditor::class)->name('notes.edit_standalone');
});