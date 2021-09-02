<?php

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function () {
    $isAdmin = Auth::user()->can('admin');
    $projectsCount = $isAdmin ? Project::count() : Project::where('owner_id', Auth::id())->count();

    return Inertia::render('Dashboard', [
        'usersCount' => User::count(),
        'projectsCount' => $projectsCount,
        'isAdmin' => $isAdmin
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
require __DIR__ . '/esb.php';
