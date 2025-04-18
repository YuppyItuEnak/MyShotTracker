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
        $request->validate([
            'date' => 'required|date',
            'trainings' => 'required|array|min:1',
            'trainings.*.location' => 'required',
            'trainings.*.attempt' => 'required|integer',
            'trainings.*.shotmade' => 'required|integer',
            'trainings.*.accuracy' => 'required|numeric',
        ]);

        $totalMade = collect($request->trainings)->sum('shotmade');
        $totalAttempt = collect($request->trainings)->sum('attempt');
        $totalAccuracy = $totalAttempt > 0 ? ($totalMade / $totalAttempt) * 100 : 0;

        $overall = OverallShot::create([
            'user_id' => (int) $request->user_id,
            'date' => $request->date,
            'totalmade' => $totalMade,
            'totalattempt' => $totalAttempt,
            'totalaccuracy' => $totalAccuracy
        ]);

        foreach ($request->trainings as $data) {
            ShotTraining::create([
                'overall_shot_id' => $overall->id,
                'location' => $data['location'],
                'attempt' => $data['attempt'],
                'shotmade' => $data['shotmade'],
                'accuracy' => $data['accuracy'],
            ]);
        }

        return redirect()->back()->with('success', 'Training saved successfully!');
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
