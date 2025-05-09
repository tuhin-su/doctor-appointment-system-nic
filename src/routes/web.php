<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
Route::get('/', [PageController::class, 'root']);
Route::get('/{page}', [PageController::class, 'index'])->name('page');
