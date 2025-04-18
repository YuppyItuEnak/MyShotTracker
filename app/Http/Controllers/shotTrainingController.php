<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotTraining;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShotTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $session = ShotTraining::latest()->first();

        return view('Pemain.addTraining', ['session' => $session]); // render blade view
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
        $today = Carbon::today();

        $overall = OverallShot::firstOrCreate(
            ['date' => $today],
            ['totalmade' => 0, 'totalattempt' => 0, 'totalaccuracy' => 0]
        );

        $session = ShotTraining::create([
            'location' => $request->input('location'),
            'attempt' => $request->input('attempt'),
            'shotmade' => 0,
            'accuracy' => 0, // karena belum tahu, nanti dihitung ulang
            'is_active' => true,
            'overall_shot_id' => $overall->id,
        ]);

        return redirect('/training-status-page');
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
