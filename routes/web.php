<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpellCheckController;

// Home page (with embedded spellcheck form)
Route::get('/', function () {
    return view('home'); // see resources/views/home.blade.php
})->name('home');

// (Optional) Dedicated spellcheck page
Route::get('/spellcheck', [SpellCheckController::class, 'showPage'])
     ->name('spellcheck.page');

// Handle AJAX POST from the form
Route::post('/spellcheck', [SpellCheckController::class, 'correctText'])
     ->name('spellcheck.check');

// Other informational pages
Route::get('/info', function () {
    return view('info');
})->name('info');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');