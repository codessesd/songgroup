<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
  $access = session('access', 0);
  if ($access === 0) {
    session(['access' => 1]);
    return redirect()->route('pianoChords');
  }
  return Inertia::render('Welcome');
})->name('home');

Route::inertia('/pianochords', 'pianoChords/Index')->name('pianoChords');

Route::middleware(['auth', 'verified'])->group(function () {
  Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});


require __DIR__ . '/settings.php';
