<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OverallShotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overallShot = OverallShot::where('user_id', Auth::user()->id)->get();

        // $shotTraining = ShotTraining::all();
        return view('Pemain.shotTrainingView', compact('overallShot'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd(request()->all());
        $userId = Auth::user()->id;
        // Ambil semua latihan yang belum dikelompokkan (is_active = false dan belum punya overall_shot_id)
        $trainings = ShotTraining::where('is_active', false)
            ->whereNull('overall_shot_id')
            ->get();

        if ($trainings->isEmpty()) {
            return response()->json(['message' => 'Tidak ada sesi latihan yang selesai.'], 400);
        }

        // Hitung total attempt dan shotmade
        $totalAttempt = $trainings->sum('attempt');
        $totalShotmade = $trainings->sum('shotmade');

        // Buat overall_shot
        $overall = OverallShot::create([
            'user_id' => $userId,
            'date' => now(),
            'totalmade' => $totalAttempt,
            'totalattempt' => $totalShotmade,
        ]);

        // Update setiap shot_training agar terhubung ke overall_shot_id
        foreach ($trainings as $training) {
            $training->update(['overall_shot_id' => $overall->id]);
        }

        return response()->json([
            'message' => 'Sesi latihan berhasil disimpan sebagai overall_shots.',
            'overall_id' => $overall->id,
            'total_attempt' => $totalAttempt,
            'total_shotmade' => $totalShotmade
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
