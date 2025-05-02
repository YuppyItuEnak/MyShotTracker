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


// Route::post('/sensor/shot-made', function (Request $request) {
//     $validated = $request->validate([
//         'sensor_id' => 'required|string',
//         'value' => 'required|boolean', // true when shot is made
//     ]);

//     // Find the active training session
//     $activeTraining = ShotTraining::where('is_active', true)
//         ->latest()
//         ->first();

//     if (!$activeTraining) {
//         return response()->json([
//             'success' => false,
//             'message' => 'No active training session found'
//         ]);
//     }

//     // Only increment if value is true (shot made) and not reached the target yet
//     if ($validated['value'] && $activeTraining->shotmade < $activeTraining->attempt) {
//         $activeTraining->shotmade = $activeTraining->shotmade + 1;

//         // Update accuracy in real-time
//         if ($activeTraining->attempt > 0) {
//             $activeTraining->accuracy = ($activeTraining->shotmade / $activeTraining->attempt) * 100;
//         }

//         $activeTraining->save();
//     }

//     return response()->json([
//         'success' => true,
//         'current_shots' => $activeTraining->shotmade,
//         'target' => $activeTraining->attempt,
//         'accuracy' => $activeTraining->accuracy,
//         'is_complete' => $activeTraining->shotmade >= $activeTraining->attempt
//     ]);
// });



Route::post('/update-training-counter', function (Request $request) {
    $session = ShotTraining::where('is_active', true)->latest()->first();

    if ($session) {
        // Jangan update jika sudah melebihi attempt
        if ($session->shotmade >= $session->attempt) {
            return response()->json(['message' => 'Semua attempt sudah dilakukan'], 400);
        }

        $session->shotmade += 1;
        $session->save();

        return response()->json(['message' => 'Shot made counted']);
    }

    return response()->json(['success' => false], 404);
});

Route::post('/finish-training-session', function (Request $request) {
    $session = ShotTraining::where('is_active', true)->latest()->first();

    if (!$session) {
        return response()->json(['success' => false, 'message' => 'Tidak ada sesi aktif'], 404);
    }

    if ($session->shotmade < $session->attempt) {
        return response()->json(['message' => 'Latihan belum selesai, masih ada attempt tersisa'], 400);
    }

    $session->is_active = false;
    $session->accuracy = ($session->shotmade / $session->attempt) * 100;
    $session->save();



    return response()->json(['message' => 'Sesi latihan diselesaikan']);
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
        'is_active' => $session->is_active,
        'duration' => $session->duration // Added duration field
    ]);
});
