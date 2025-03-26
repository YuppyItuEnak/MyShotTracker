<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotTraining;
use App\Models\TrainingCount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainingCounts = TrainingCount::all();

        $pemain = User::where('role', 'pemain')->first();
        $overallShot = OverallShot::where('user_id', $pemain->id)->get();
        // Debugging
        // dd($overallShot);


        return view('Pelatih.Dashboard', compact('trainingCounts', 'overallShot'));
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
        //
    }

    /**
     * Display the specified resource.
     */

    //Memanggil Id untuk overallshot
    public function show(string $id)
    {
        $overallShot = OverallShot::findOrFail($id);

        $allShots = OverallShot::where('user_id', $overallShot->user_id)
        ->orderBy('date', 'ASC')
        ->get(['date', 'totalaccuracy']);

    // Kelompokkan data berdasarkan minggu
    $weeks = [];
    foreach ($allShots as $shot) {
        $weekNumber = \Carbon\Carbon::parse($shot->date)->format('W'); // Ambil minggu dari tanggal
        $weeks[$weekNumber][] = [
            'label' => \Carbon\Carbon::parse($shot->date)->format('d M'),
            'value' => $shot->totalaccuracy
        ];
    }

        return view('Pelatih.DetailPlayer', compact('overallShot', 'weeks'));
    }

    //Memanggil id untuk shotTraining
    public function showDetailShot(string $id)
    {
        $overallShot = OverallShot::findOrFail($id);
        $shotTraining = ShotTraining::where('overall_shot_id', $overallShot->id ?? null)->get();
        // dd($shotTraining);
        return view('Pelatih.DetailShotPlayer', compact('overallShot', 'shotTraining'));
    }

    public function reportPlayerProgress()
    {
        $overallShot = OverallShot::orderBy('date', 'asc')->get();

        $weeks = [];
        $currentWeek = [];
        $weekCounter = 1;

        foreach ($overallShot as $index => $shot) {
            $date = Carbon::parse($shot->date);

            // Jika sudah 7 hari dalam satu minggu, buat minggu baru
            if (count($currentWeek) >= 7) {
                $weeks["Week $weekCounter"] = $currentWeek; // Simpan minggu sebelumnya
                $weekCounter++;
                $currentWeek = []; // Reset minggu baru
            }

            // Tambahkan data ke minggu yang sedang berjalan
            $currentWeek[] = [
                'label' => $date->format('M d'),
                'value' => $shot->totalaccuracy
            ];
        }

        // Simpan minggu terakhir jika ada
        if (!empty($currentWeek)) {
            $weeks["Week $weekCounter"] = $currentWeek;
        }

        return view('Pelatih.DetailPlayer', compact('weeks', 'overallShot'));
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
