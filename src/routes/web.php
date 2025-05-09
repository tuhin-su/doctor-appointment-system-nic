<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
// Default root route
Route::get('/', [PageController::class, 'root']);

// Dynamic page route
Route::get('/{page}', [PageController::class, 'index'])->name('page');
