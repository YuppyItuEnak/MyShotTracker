<?php

use App\Http\Controllers\shootingTrainingController;
use App\Http\Controllers\shotTrainingController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('Pemain.shotTrainingView');
// });

// Route::get('/training', function () {
//     return view('Pemain.addTraining');
// });


// Route::resource('pemain', shotTrainingController::class);
Route::get('/', [shotTrainingController::class, 'index'])->name('pemain.index');
Route::get('/create', [shotTrainingController::class, 'create'])->name('pemain.create');
Route::post('/store', [shotTrainingController::class, 'store'])->name('pemain.store');

//Testing masukan data secara manual
Route::post('/testSimpan', [shotTrainingController::class, 'test'])->name('pemain.testSimpan');

