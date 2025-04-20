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
Route::get('/index', [OverallShotController::class, 'index'])->name('pemain.index');
Route::get('/create', [ShotTrainingController::class, 'create'])->name('pemain.create');
// Route::post('/store', [shotTrainingController::class, 'store'])->name('pemain.store');
// Route::get('/detail/{id}', [shotTrainingController::class, 'show'])->name('pemain.show');
// Route::get('/report', [shotTrainingController::class, 'reportProgress'])->name('pemain.reportProgress');

Route::get('/', [UserController::class, 'create'])->name('signup');
Route::get('/login', [UserController::class, 'logincreate'])->name('login');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/userlogin', [UserController::class, 'login'])->name('login.store');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');



// Route::get('/pelatihdasboard', [DashboardController::class, 'index'])->name('pelatih.index');
// Route::get('/reportplayer', [DashboardController::class, 'reportPlayerProgress'])->name('pelatih.reportProgress');
// Route::get('/detailplayer/{id}', [DashboardController::class, 'show'])->name('pelatih.show');
// Route::get('/detailshotplayer/{id}', [DashboardController::class, 'showDetailShot'])->name('pelatih.showDetailShot');
// Route::get('/player', [UserController::class, 'index'])->name('pelatih.player.index');



// //Testing masukan data secara manual
// Route::post('/testSimpan', [shotTrainingController::class, 'test'])->name('pemain.testSimpan');




// routes/web.php
// Route::post('/add-training', [OverallShotController::class, 'store'])->name('training.store');


// Route::get('/addtraining', function () {
//     return view('Pemain.addTraining');
// });
// Route::post('/training/start', [ShotTrainingController::class, 'startSession'])->name('training.start');
// Route::post('/training/finish', [ShotTrainingController::class, 'finishSession'])->name('training.finish');
// Route::get('/api/training-status/{sessionId}', [ShotTrainingController::class, 'getStatus']);


Route::post('/start-training', [ShotTrainingController::class, 'store'])->name('training.store');
Route::post('/finish-training', [OverallShotController::class, 'store']);
Route::post('/update-overall', [shotTrainingController::class, 'updateData'])->name('training.updateData');

Route::get('/training-status-page', [ShotTrainingController::class, 'index'])->name('training.index');
