<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotTraining;
use App\Models\TrainingCount;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class shotTrainingController_old extends Controller
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
        return view('Pemain.addTraining');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'data' => 'required|array|min:1',
            'data.*.location' => 'required|in:Right Corner,Left Corner,Top,Right Wing,Left Wing,Right Short Corner,Left Short Corner,Right Elbow,Left Elbow,Top Of The Key',
            'data.*.shotmade' => 'required|integer|min:0',
            'data.*.attempt' => 'required|integer|min:1',
        ]);
        // dd("Validasi sukses!");

        $user = User::where('id', $request->user_id)->where('role', 'pemain')->first();

        if (!$user) {
            return redirect()->back()->with('error', 'User harus memiliki role pemain.');
        }

        $totalMade = 0;
        $totalAttempt = 0;

        // Menambah total shotmade dan attempt dari berbagai lokasi
        foreach ($request->data as $shot) {
            $totalMade += (int) $shot['shotmade'];
            $totalAttempt += (int) $shot['attempt'];
        }

        // dd($request->user_id);


        // Memasukan overallShot data ke database
        $overallShot = OverallShot::create([
            'user_id' => (int) $request->user_id, // Tambahkan user_id agar ada relasi ke pemain
            'totalmade' => $totalMade,
            'totalattempt' => $totalAttempt,
            'totalaccuracy' => $totalAttempt > 0 ? ($totalMade / $totalAttempt) * 100 : 0,
            'date' => $request->input('date', now()->format('Y-m-d')),
        ]);

        // dd($overallShot);
        // dd($request->data);
        // Memasukan ShotTraining Data dari berbagai lokasi ke database
        foreach ($request->data as $shot) {
            ShotTraining::create([
                'overall_shot_id' => $overallShot->id,
                'location' => $shot['location'],
                'shotmade' => (int) $shot['shotmade'],
                'attempt' => (int) $shot['attempt'],
                'accuracy' => ((int) $shot['shotmade'] / (int) $shot['attempt']) * 100,
            ]);
        }
        // dd(ShotTraining::all());


        // Perbarui TrainingCount setelah menyimpan OverallShot
        $this->updateTrainingCount($request->user_id);

        return redirect()->route('pemain.index')->with('success', 'Training saved successfully.');
    }

    /**
     * Function untuk mengupdate training_count berdasarkan user pemain.
     */
    private function updateTrainingCount($userId)
    {
        $user = User::where('id', $userId)->where('role', 'pemain')->first();

        if (!$user) {
            dd("User tidak ditemukan atau bukan pemain!");
        }

        // Hitung total training berdasarkan OverallShot
        $totalTraining = OverallShot::where('user_id', $userId)->count();

        // Update atau buat baru data di TrainingCount
        TrainingCount::updateOrCreate(
            ['user_id' => $userId],
            ['training_count' => $totalTraining]
        );


    }




    public function reportProgress()
    {
        $overallShot = OverallShot::where('user_id', Auth::user()->id)->get();
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

        return view('pemain.shotProgress', compact('weeks', 'overallShot'));
    }



    public function test()
    {
        // Simpan OverallShot secara manual
        $overallShot = OverallShot::create([
            'totalmade' => 20, // Total masuk
            'totalattempt' => 40, // Total percobaan
            'totalaccuracy' => (20 / 40) * 100, // Akurasi
        ]);

        // Simpan beberapa data ke ShotTraining secara manual
        ShotTraining::create([
            'overall_shot_id' => $overallShot->id,
            'location' => 'Right Corner',
            'shotmade' => 5,
            'attempt' => 10,
            'accuracy' => (5 / 10) * 100,
            'date' => now()->format('Y-m-d'),
        ]);

        ShotTraining::create([
            'overall_shot_id' => $overallShot->id,
            'location' => 'Left Corner',
            'shotmade' => 7,
            'attempt' => 10,
            'accuracy' => (7 / 10) * 100,
            'date' => now()->format('Y-m-d'),
        ]);

        ShotTraining::create([
            'overall_shot_id' => $overallShot->id,
            'location' => 'Top',
            'shotmade' => 8,
            'attempt' => 10,
            'accuracy' => (8 / 10) * 100,
            'date' => now()->format('Y-m-d'),
        ]);

        return response()->json(['message' => 'Data shooting berhasil dimasukkan secara manual!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // dd($id);
        $overallShot = OverallShot::findOrFail($id);
        $shotTraining = ShotTraining::where('overall_shot_id', $id)->get();
        // dd($shotTraining);xX
        return view('Pemain.shotTrainingDetail', compact('shotTraining', 'overallShot'));
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
