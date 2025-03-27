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

        $players = User::where('role', 'pemain')->with(['overallShots'])->get(); // Ambil semua pemain

        // Ambil OverallShot per pemain
        // $overallShot = OverallShot::whereIn('user_id', $players->pluck('id'))
        //     ->get()
        //     ->groupBy('user_id'); // Kelompokkan berdasarkan user_id
        // $overallShot = OverallShot::where('user_id', $players->id)->get();
        // dd($overallShot);

        return view('Pelatih.Dashboard', compact('players'));
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
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $overallShot = OverallShot::where('user_id', $id)->get();
        // dd($overallShot);

        $trainingcount = TrainingCount::where('user_id', $id)->first();
        $trainingcount = $trainingcount->training_count;
        // dd($trainingcount);

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

        if (!empty($currentWeek)) {
            $weeks["Week $weekCounter"] = $currentWeek;
        }

        return view('Pelatih.DetailPlayer', compact('weeks', 'user', 'overallShot', 'trainingcount'));
    }

    //Memanggil id untuk shotTraining
    public function showDetailShot(string $id)
    {
        $overallShot = OverallShot::findOrFail($id);
        // dd($overallShot);
        $shotTraining = ShotTraining::where('overall_shot_id', $id)->get();

        // dd($shotTraining);
        return view('Pelatih.DetailShotPlayer', compact('shotTraining', 'overallShot'));
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
