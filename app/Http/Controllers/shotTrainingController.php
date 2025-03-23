<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotTraining;
use Carbon\Carbon;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;

class shotTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overallShot = OverallShot::all();
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
            // 'user_id' => 'required|exists:users,id',
            'data' => 'required|array|min:1',
            'data.*.location' => 'required|in:Right Corner,Left Corner,Top,Right Wing,Left Wing',
            'data.*.shotmade' => 'required|integer|min:0',
            'data.*.attempt' => 'required|integer|min:1',
            // 'data.*.duration' => 'required|string',
        ]);



        $totalMade = 0;
        $totalAttempt = 0;

        //Menambah total shotmade dan attempt dari berbagai lokasi
        foreach ($request->data as $shot) {
            $totalMade += (int) $shot['shotmade'];
            $totalAttempt += (int) $shot['attempt'];
        }

        //Memasukan overallShot data ke database
        $overallShot = OverallShot::create([
            'totalmade' => $totalMade,
            'totalattempt' => $totalAttempt,
            'totalaccuracy' => $totalAttempt > 0 ? ($totalMade / $totalAttempt) * 100 : 0,
            'date' => request()->input('date', now()->format('Y-m-d')),
        ]);


        //Memasukan ShotTraining Data dari berbagai lokasi pada database
        foreach ($request->data as $shot) {
            ShotTraining::create([
                'overall_shot_id' => $overallShot->id,
                'location' => $shot['location'],
                'shotmade' => (int) $shot['shotmade'],
                'attempt' => (int) $shot['attempt'],
                'accuracy' => ((int) $shot['shotmade'] / (int) $shot['attempt']) * 100,
            ]);
        }

        return redirect()->route('pemain.index')->with('success', 'Training saved successfully.');
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
