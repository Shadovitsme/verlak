<?php

use App\Http\Controllers\deleteDataController;
use App\Http\Controllers\fileUploadController;
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
Route::get('/up', function () {
    return Inertia::render('uploadFile');
});
Route::get('/notifications', function () {
    return Inertia::render('notifications');
});

Route::get('/addWorker', function () {
    return Inertia::render('addWorker');
});
Route::get('/dashboard', function () {
    return Inertia::render('contracts');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/contracts', function () {
    return Inertia::render('contracts');
});

Route::get('/contracts/{contractNumber}/{adressId}', function (string $contractNumber, string $adressId) {
    return Inertia::render('adress', [
        'contractNumber' => $contractNumber,
        'adressId' => $adressId,
    ]);
});

Route::get('/execContract/{contractNumber?}', function (?string $contractNumber = null) {
    return Inertia::render('contracts', [
        'contractNumber' => $contractNumber,
    ]);
})->where('contractNumber', '[^\/]+');

Route::get('/updateWorker/{workerId}', function (
    string $workerId,
) {
    return Inertia::render('updateWorker', [
        'workerId' => $workerId,
    ]);
});

Route::get('/{contractNumber}/{adressId}/{entranceName}', function (string $contractNumber, string $adressId, string $entranceName) {
    return Inertia::render('entrance', [
        'contractNumber' => $contractNumber,
        'adressId' => $adressId,
        'entranceName' => $entranceName,
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', RoleMiddleware::class . ':administrator'])->group(function () {
    Route::get('/admin', function () {
        return Inertia::render('managerListPage');
    });
    Route::get('/executors', function () {
        return Inertia::render('workers');
    });
});

// Apies
Route::get('/user', [getDataController::class, 'getAllManagers']);
Route::get('/getContracts', [getDataController::class, 'getAllContracts']);
Route::get('/getExecContract', [getDataController::class, 'getExecContract']);
Route::get('/getAdressesforContract', [getDataController::class, 'getAdressesforContract']);
Route::get('/getCurrentAdressData', [getDataController::class, 'getCurrentAdressData']);
Route::get('/getExecEntrance', [getDataController::class, 'getExecEntrance']);
Route::get('/getExecElevator', [getDataController::class, 'getExecElevator']);
Route::get('/getBuildingData', [getDataController::class, 'getBuildingData']);
Route::get('/getContactListData', [getDataController::class, 'getContactListData']);
Route::get('/getContactPersonData', [getDataController::class, 'getContactPersonData']);
Route::get('/getDocuments', [getDataController::class, 'getDocuments']);
Route::get('/getEED', [getDataController::class, 'getEED']);
Route::get('/getPictures', [getDataController::class, 'getPictures']);
Route::get('/universalGetter', [getDataController::class, 'universalGetter']);
Route::get('/getAllWorkerData', [getDataController::class, 'getAllWorkerData']);
Route::get('/getExecWorkerData', [getDataController::class, 'getExecWorkerData']);
Route::get('/getAllAccountancy', [getDataController::class, 'getAllAccountancy']);
Route::get('/getODSH', [getDataController::class, 'getODSH']);

Route::post('/deleteManager', [deleteDataController::class, 'deleteManager']);
Route::post('/universalDelete', [deleteDataController::class, 'universalDelete']);
Route::post('/deleteEntrance', [deleteDataController::class, 'deleteEntrance']);
Route::post('/deleteElevator', [deleteDataController::class, 'deleteElevator']);
Route::post('/deleteBuildingData', [deleteDataController::class, 'deleteBuildingData']);

Route::post('/updateManager', [setDataController::class, 'updateManager']);
Route::post('/updateContract', [setDataController::class, 'updateContract']);
Route::post('/updateElevatorData', [setDataController::class, 'updateElevatorData']);
Route::post('/updateHomeData', [setDataController::class, 'updateHomeData']);
Route::post('/updateContactPerson', [setDataController::class, 'updateContactPerson']);
Route::post('/universalUpdate', [setDataController::class, 'universalUpdate']);

Route::post('/setHeadODSH', [setDataController::class, 'setHeadODSH']);
Route::post('/setOdshTable', [setDataController::class, 'setOdshTable']);

Route::post('/addManager', [setDataController::class, 'setNewManager']);
Route::post('/addContract', [setDataController::class, 'addNewContract']);
Route::post('/addEntrance', [setDataController::class, 'addEntrance']);
Route::post('/addElevator', [setDataController::class, 'addElevator']);
Route::post('/addWorker', [setDataController::class, 'addUpdateWorker']);
Route::post('/addWorkerAdress', [setDataController::class, 'addUpdateWorkerAdress']);
Route::post('/addAvanceForAdress', [setDataController::class, 'addAvanceForAdress']);
Route::post('/addAcceptAndDisgard', [setDataController::class, 'addAcceptAndDisgard']);

Route::post('/upload-file', [FileUploadController::class, 'upload']);
Route::post('/delete-file', [FileUploadController::class, 'delete']);

// routes/web.php
Route::get('/test-image', function () {
    $path = storage_path('app/public/uploads/1/Dokumenty/1742478540_8916ce21fae90b94aa17f399ad70cf75.jpg');
    return response()->file($path);
});

require __DIR__ . '/auth.php';
