<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/project', [ProjectController::class, 'index'])
        ->name('project.index');
});
