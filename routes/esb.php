<?php

use App\Http\Controllers\NsController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::prefix('project')->group(function () {

        Route::get('/', [ProjectController::class, 'index'])
            ->name('project.index');

        Route::post('/', [ProjectController::class, 'store'])
            ->name('project.store');

        Route::get('/create', [ProjectController::class, 'create'])
            ->name('project.create');

        Route::get('/{project}', [ProjectController::class, 'edit'])
            ->name('project.edit')->middleware('can:update,project');

        Route::post('/{project}', [ProjectController::class, 'update'])
            ->name('project.update')->middleware('can:update,project');

        Route::get('/activate/{id}', [ProjectController::class, 'activate'])
            ->name('project.activate');
    });

    Route::prefix('namespace')->group(function () {

        Route::get('/', [NsController::class, 'index'])
            ->name('namespace.index');

        Route::post('/', [NsController::class, 'store'])
            ->name('namespace.store');

        Route::get('/create', [NsController::class, 'create'])
            ->name('namespace.create');

        Route::get('/{ns}', [NsController::class, 'edit'])
            ->name('namespace.edit');

        Route::post('/{ns}', [NsController::class, 'update'])
            ->name('namespace.update');

    });
});
