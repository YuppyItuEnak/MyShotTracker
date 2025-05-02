<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotSession;
use App\Models\ShotTraining;
use App\Models\TrainingCount;
use App\Models\User;
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
        $trainingSession = ShotTraining::where('overall_shot_id', null)->orderBy('created_at', 'desc')->get();
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
                'duration' => $request->input('duration'),
                'shotmade' => 0,
                'accuracy' => 0,
                'is_active' => true,
            ]);

            return redirect('/create')->with('success', 'Sesi latihan berhasil disimpan.');
        } catch (\Exception $e) {
            // log error untuk debug
            Log::error('Gagal menyimpan sesi latihan: ' . $e->getMessage());
            return back()->with('error', 'Gagal menyimpan sesi latihan.');
        }
    }

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

    /**
     * Mencari sesi latihan yang sedang aktif atau buat yang baru,
     * lalu mengumpulkan semua data ShotTraining yang belum dikelompokkan
     * dan menghubungkannya dengan OverallShot yang sedang aktif.
     * Jika OverallShot yang sedang aktif sudah ada, maka akurasi total
     * akan dihitung ulang berdasarkan total attempt dan shot made.
     */

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

        $this->updateTrainingCount(Auth::user()->id);

        // Redirect ke halaman lain setelah selesai
        return redirect()->route('Overall.index')->with('success', 'Sesi latihan berhasil digabungkan!');
    }


    /**
     * Menampilkan laporan progress latihan per minggu.
     *
     * @return \Illuminate\Http\Response
     */
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
