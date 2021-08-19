<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::prefix('project')->group(function () {

        Route::get('/', [ProjectController::class, 'index'])
            ->name('project.index');

        Route::get('/{project}', [ProjectController::class, 'edit'])
            ->name('project.edit');

        Route::post('/{project}', [ProjectController::class, 'update'])
            ->name('project.update');

        Route::get('/activate/{id}', [ProjectController::class, 'activate'])
            ->name('project.activate');
    });
});
