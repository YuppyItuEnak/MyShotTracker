<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\shootingTrainingController;
use App\Http\Controllers\shotTrainingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('Pemain.shotTrainingView');
// });

Route::get('/Dashboard', function () {
    return view('Pelatih.Dashboard');
});
Route::get('/login', function () {
    return view('Login');
});

Route::get('/signup', function () {
    return view('SignUp');
});

// Route::resource('pemain', shotTrainingController::class);

//  Routing untuk user Pemain
Route::get('/', [shotTrainingController::class, 'index'])->name('pemain.index');
Route::get('/create', [shotTrainingController::class, 'create'])->name('pemain.create');
Route::post('/store', [shotTrainingController::class, 'store'])->name('pemain.store');
Route::get('/detail/{id}', [shotTrainingController::class, 'show'])->name('pemain.show');
Route::get('/report', [shotTrainingController::class, 'reportProgress'])->name('pemain.reportProgress');

Route::get('/signup', [UserController::class, 'create'])->name('signup');
Route::get('/login', [UserController::class, 'logincreate'])->name('login');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::post('/userlogin', [UserController::class, 'login'])->name('login.store');



Route::get('/pelatihdasboard', [DashboardController::class, 'index'])->name('pelatih.index');
Route::get('/reportplayer', [DashboardController::class, 'reportPlayerProgress'])->name('pelatih.reportProgress');
Route::get('/detailplayer/{id}', [DashboardController::class, 'show'])->name('pelatih.show');
Route::get('/detailshotplayer/{id}', [DashboardController::class, 'showDetailShot'])->name('pelatih.showDetailShot');
Route::get('/player', [UserController::class, 'index'])->name('pelatih.player.index');



//Testing masukan data secara manual
Route::post('/testSimpan', [shotTrainingController::class, 'test'])->name('pemain.testSimpan');





