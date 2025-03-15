<?php

use App\Http\Controllers\deleteDataController;
use App\Http\Controllers\getDataController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\setDataController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/contracts', function () {
    return Inertia::render('contracts');
});

Route::get('/scores', function () {
    return Inertia::render('scores');
});
Route::get('/notifications', function () {
    return Inertia::render('notifications');
});
Route::get('/executors', function () {
    return Inertia::render('executors');
});
Route::get('/dashboard', function () {
    return Inertia::render('managerListPage');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class . ':administrator'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('managerListPage');
    });
});

// Apies
Route::get('/user', [getDataController::class, 'getAllManagers']);
Route::get('/getContracts', [getDataController::class, 'getAllContracts']);
Route::get('/getExecContract', [getDataController::class, 'getExecContract']);
Route::get('/getAdressesforContract', [getDataController::class, 'getAdressesforContract']);


Route::post('/deleteManager', [deleteDataController::class, 'deleteManager']);
Route::post('/addManager', [setDataController::class, 'setNewManager']);
Route::post('/updateManager', [setDataController::class, 'updateManager']);
Route::post('/addContract', [setDataController::class, 'addNewContract']);

require __DIR__ . '/auth.php';
