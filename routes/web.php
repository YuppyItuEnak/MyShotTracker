<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OverallShotController;
use App\Http\Controllers\shootingTrainingController;
use App\Http\Controllers\shotTrainingController;
use App\Http\Controllers\ShotTrainingController as ControllersShotTrainingController;
use App\Http\Controllers\UserController;
use App\Models\OverallShot;
use App\Models\ShotTraining;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('Pemain.shotTrainingView');
// });

// Route::get('/Dashboard', function () {
//     return view('Pelatih.Dashboard');
// });
// Route::get('/login', function () {
//     return view('Login');
// });

// Route::get('/', function () {
//     return view('welcome');
// });



// Route::resource('pemain', shotTrainingController::class);



// //  Routing untuk user Pemain
Route::get('/index', [OverallShotController::class, 'index'])->name('Overall.index');
Route::post('/finish-training', [OverallShotController::class, 'store']);



Route::get('/create', [ShotTrainingController::class, 'create'])->name('training.create');
Route::post('/start-training', [ShotTrainingController::class, 'store'])->name('training.store');
Route::post('/update-overall', [shotTrainingController::class, 'updateData'])->name('training.updateData');
Route::get('/training-status-page', [ShotTrainingController::class, 'index'])->name('training.index');
Route::get('/detail/{id}', [shotTrainingController::class, 'show'])->name('training.show');
Route::get('/report', [shotTrainingController::class, 'reportProgress'])->name('training.reportProgress');

Route::get('/', [UserController::class, 'create'])->name('signup');
Route::get('/login', [UserController::class, 'logincreate'])->name('login');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/userlogin', [UserController::class, 'login'])->name('login.store');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');



Route::get('/pelatihdasboard', [DashboardController::class, 'index'])->name('pelatih.index');
Route::get('/reportplayer', [DashboardController::class, 'reportPlayerProgress'])->name('pelatih.reportProgress');
Route::get('/detailplayer/{id}', [DashboardController::class, 'show'])->name('pelatih.show');
Route::get('/detailshotplayer/{id}', [DashboardController::class, 'showDetailShot'])->name('pelatih.showDetailShot');
Route::get('/player', [UserController::class, 'index'])->name('pelatih.player.index');








