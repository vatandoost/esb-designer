<?php

use App\Http\Controllers\AdapterController;
use App\Http\Controllers\DbController;
use App\Http\Controllers\FuncController;
use App\Http\Controllers\NsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProviderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UtilityController;
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

        Route::delete('/{project}', [ProjectController::class, 'destroy'])
            ->name('project.delete')->middleware('can:update,project');

        Route::post('/activate/{project}', [ProjectController::class, 'activate'])
            ->name('project.activate')->middleware('can:update,project');
    });

    Route::prefix('namespace')->middleware('can:active-project')->group(function () {

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

        Route::delete('/{ns}', [NsController::class, 'destroy'])
            ->name('namespace.delete');
    });

    Route::prefix('database')->middleware('can:active-project')->group(function () {

        Route::get('/', [DbController::class, 'index'])
            ->name('database.index');

        Route::post('/', [DbController::class, 'store'])
            ->name('database.store');

        Route::get('/create', [DbController::class, 'create'])
            ->name('database.create');

        Route::get('/{db}', [DbController::class, 'edit'])
            ->name('database.edit');

        Route::post('/{db}', [DbController::class, 'update'])
            ->name('database.update');
        Route::delete('/{db}', [DbController::class, 'destroy'])
            ->name('database.delete');
    });

    Route::prefix('adapter')->middleware('can:active-project')->group(function () {

        Route::get('/', [AdapterController::class, 'index'])
            ->name('adapter.index');

        Route::post('/', [AdapterController::class, 'store'])
            ->name('adapter.store');

        Route::get('/create', [AdapterController::class, 'create'])
            ->name('adapter.create');

        Route::get('/{adapter}', [AdapterController::class, 'edit'])
            ->name('adapter.edit');

        Route::post('/{adapter}', [AdapterController::class, 'update'])
            ->name('adapter.update');
        Route::delete('/{adapter}', [AdapterController::class, 'destroy'])
            ->name('adapter.delete');

        Route::get('/options/{func}/{type}', [AdapterController::class, 'options'])
            ->name('adapter.options');
    });

    Route::prefix('function')->middleware('can:active-project')->group(function () {

        Route::get('/', [FuncController::class, 'index'])
            ->name('function.index');

        Route::post('/', [FuncController::class, 'store'])
            ->name('function.store');

        Route::get('/create', [FuncController::class, 'create'])
            ->name('function.create');

        Route::get('/edit/{func}', [FuncController::class, 'edit'])
            ->name('function.edit');

        Route::post('/{func}', [FuncController::class, 'update'])
            ->name('function.update');
        Route::delete('/{func}', [FuncController::class, 'destroy'])
            ->name('function.delete');
        Route::get('/{func}', [FuncController::class, 'show'])
            ->name('function.show');

        Route::get('/definition/{func}', [FuncController::class, 'definition'])
            ->name('function.definition');
        Route::post('/definition/{func}', [FuncController::class, 'definitionStore'])
            ->name('function.definition.store');

        Route::get('/parameters/{func}', [FuncController::class, 'parameters'])
            ->name('function.parameters');
        Route::post('/parameters/edit/{funcParam}', [FuncController::class, 'parameterSave'])
            ->name('function.parameter.edit');
        Route::delete('/parameters/delete/{funcParam}', [FuncController::class, 'parameterDelete'])
            ->name('function.parameter.delete');
        Route::post('/parameters/save', [FuncController::class, 'parameterSave'])
            ->name('function.parameter.save');
    });

    Route::prefix('provider')->middleware('can:active-project')->group(function () {

        Route::get('/', [ProviderController::class, 'index'])
            ->name('provider.index');

        Route::post('/', [ProviderController::class, 'store'])
            ->name('provider.store');

        Route::get('/create', [ProviderController::class, 'create'])
            ->name('provider.create');

        Route::get('/{provider}', [ProviderController::class, 'edit'])
            ->name('provider.edit');

        Route::post('/{provider}', [ProviderController::class, 'update'])
            ->name('provider.update');
        Route::delete('/{provider}', [ProviderController::class, 'destroy'])
            ->name('provider.delete');
    });

    Route::prefix('user')->middleware('can:admin')->group(function () {

        Route::get('/', [UserController::class, 'index'])
            ->name('user.index');

        Route::post('/', [UserController::class, 'store'])
            ->name('user.store');

        Route::get('/create', [UserController::class, 'create'])
            ->name('user.create');

        Route::get('/{user}', [UserController::class, 'edit'])
            ->name('user.edit');

        Route::post('/{user}', [UserController::class, 'update'])
            ->name('user.update');

        Route::delete('/{user}', [UserController::class, 'destroy'])
            ->name('user.delete');
    });
    Route::prefix('profile')->group(function () {
        Route::get('/', [UserController::class, 'profile'])
            ->name('user.profile');
        Route::post('/', [UserController::class, 'updateProfile'])
            ->name('user.profile.update');
    });

    Route::prefix('utility')->group(function () {

        Route::get('/conditions', [UtilityController::class, 'condition_builder_setting'])
            ->name('utility.conditions');
    });
});
