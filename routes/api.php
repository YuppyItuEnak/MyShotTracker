<?php

use App\Http\Controllers\SensorController;
use App\Http\Controllers\ShotTrainingController;
use App\Models\SensorPoint;
use App\Models\ShotTraining;
use Carbon\Carbon;
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
        // Jangan update jika sudah melebihi attempt
        if ($session->shotmade >= $session->attempt) {
            return response()->json(['message' => 'Semua attempt sudah dilakukan'], 400);
        }

        $session->shotmade += 1;

        // Check if we've reached our target
        if ($session->shotmade >= $session->attempt) {
            $session->is_active = false;
            $session->accuracy = ($session->shotmade / $session->attempt) * 100;
        }

        $session->save();

        return response()->json([
            'message' => 'Shot made counted',
            'shotmade' => $session->shotmade,
            'attempt' => $session->attempt,
            'is_active' => $session->is_active
        ]);
    }

    return response()->json(['success' => false], 404);
});

Route::post('/finish-training-session', function (Request $request) {
    $session = ShotTraining::where('is_active', true)->latest()->first();

    if (!$session) {
        return response()->json(['success' => false, 'message' => 'Tidak ada sesi aktif'], 404);
    }
    $session->is_active = false;
    $session->accuracy = ($session->shotmade / $session->attempt) * 100;
    $session->save();

    return response()->json(['message' => 'Sesi latihan diselesaikan']);
});

Route::post('/update-timer-status', function (Request $request) {
    $timerExpired = $request->input('timer_expired', false);

    if ($timerExpired) {
        $session = ShotTraining::where('is_active', true)->latest()->first();

        if ($session) {
            // akhiri sesi jika timer sudah habis
            $session->is_active = false;
            $session->accuracy = $session->attempt > 0 ? ($session->shotmade / $session->attempt) * 100 : 0;
            $session->save();

            return response()->json([
                'success' => true,
                'message' => 'Session ended due to timer expiration',
                'shotmade' => $session->shotmade,
                'attempt' => $session->attempt,
                'accuracy' => $session->accuracy
            ]);
        }
    }

    return response()->json(['success' => false, 'message' => 'No active session or invalid request']);
});


//Melakukan update untuk waktu training (duration)
Route::post('/update-training-time', function (Request $request) {
    $duration = $request->input('duration');

    $session = ShotTraining::where('is_active', true)->latest()->first();

    if ($session) {
        $session->duration = $duration;
        $session->save();

        return response()->json(['success' => true, 'message' => 'Training time updated']);
    }

    return response()->json(['success' => false, 'message' => 'No active session found']);
});



//Menampilkan training yang dilakukan secara realtime dengan sesi yang lagi aktif
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
        'is_active' => $session->is_active,

    ]);
});
