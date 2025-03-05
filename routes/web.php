<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Pemain.shotTrainingView');
});

Route::get('/training', function () {
    return view('Pemain.addTraining');
});
