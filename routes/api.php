<?php

use App\Http\Controllers\SensorController;
use App\Http\Controllers\ShotTrainingController;
use App\Models\SensorPoint;
use App\Models\ShotTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/update-training-counter', function (Request $request) {
    $session = ShotTraining::where('is_active', true)->latest()->first();

    if ($session) {
        $session->shotmade += 1;

        // Jika shotmade belum mencapai batas attempt
        if ($session->shotmade < $session->attempt) {
            $session->save();
            return response()->json(['message' => 'Shot made counted']);
        }

        // Jika sudah selesai: hitung akurasi, matikan sesi, dan update overall
        $session->is_active = false;
        $session->accuracy = ($session->shotmade / $session->attempt) * 100;
        $session->save();

        // Update ke OverallShot
        $overall = $session->overallShot;
        $overall->totalmade += $session->shotmade;
        $overall->totalattempt += $session->attempt;
        $overall->totalaccuracy = ($overall->totalmade / $overall->totalattempt) * 100;
        $overall->save();

        return response()->json(['message' => 'Sesi selesai dan data overall diperbarui']);
    }

    return response()->json(['success' => false], 404);
});

Route::get('/training-status', function () {
    $session = ShotTraining::where('is_active', true)->latest()->first();

    if (!$session) {
        return response()->json(['message' => 'No session active'], 404);
    }

    return response()->json([
        'location' => $session->location,
        'attempt' => $session->attempt,
        'shotmade' => $session->shotmade,
        'accuracy' => $session->accuracy,
        'is_active' => $session->is_active
    ]);
});
