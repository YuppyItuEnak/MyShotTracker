<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotSession;
use App\Models\ShotTraining;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ShotTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trainingSession = ShotTraining::where('overall_shot_id',null )->orderBy('created_at', 'desc')->get();
       return view('Pemain.ShotTrainingView', compact('trainingSession'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $session = ShotTraining::latest()->first();

        return view('Pemain.addTraining', ['session' => $session]);
    }

    /**
     * Store a newly created resource in storage.
     */



    public function store(Request $request)
    {
        try {
            $session = ShotTraining::create([
                'location' => $request->input('location'),
                'attempt' => $request->input('attempt'),
                'shotmade' => 0,
                'accuracy' => 0,
                'is_active' => true,
                // 'overall_shot_id' => $overall->id,
            ]);

            return redirect('/create')->with('success', 'Sesi latihan berhasil disimpan.');
        } catch (\Exception $e) {
            // log error untuk debug
            Log::error('Gagal menyimpan sesi latihan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan sesi latihan.');
        }
    }

    public function updateData()
    {
        $today = Carbon::today();
         // Cari sesi latihan yang sedang aktif atau buat yang baru
         $overallShot = OverallShot::create([
            'user_id' => Auth::user()->id,
            'totalattempt' => 0,
            'totalmade' => 0,
            'totalaccuracy' => 0,
            'date' => $today,
        ]);

        // Ambil seluruh data ShotTraining dengan overall_shot_id NULL
        $pendingShots = ShotTraining::whereNull('overall_shot_id')->get();

        foreach ($pendingShots as $shot) {
            // Update masing-masing ShotTraining untuk menghubungkannya dengan OverallShot
            $shot->overall_shot_id = $overallShot->id;
            $shot->save();

            // Tambahkan attempt dan shot made ke sesi latihan
            $overallShot->totalattempt += $shot->attempt;
            $overallShot->totalmade += $shot->shotmade;
        }

        // Update akurasi total
        if ($overallShot->totalattempt > 0) {
            $overallShot->totalaccuracy = ($overallShot->totalmade / $overallShot->totalattempt) * 100;
        }

        // Simpan perubahan sesi latihan
        $overallShot->save();

        // Redirect ke halaman lain setelah selesai
        return redirect()->route('pemain.create')->with('success', 'Sesi latihan berhasil digabungkan!');
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
