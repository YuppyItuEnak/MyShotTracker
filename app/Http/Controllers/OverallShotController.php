<?php

namespace App\Http\Controllers;

use App\Models\OverallShot;
use App\Models\ShotTraining;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OverallShotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Start with a base query
        $query = OverallShot::where('user_id', Auth::user()->id);

        // Apply date filter if provided
        if ($request->filled('filter_date')) {
            try {
                $date = Carbon::parse($request->filter_date)->format('Y-m-d');
                $query->whereDate('date', $date);
            } catch (\Exception $e) {
                // Handle invalid date format
            }
        }

        $currentDate = $request->input('date') ? Carbon::parse($request->input('date')) : Carbon::now();
        $daysInMonth = $currentDate->daysInMonth;
        $firstDay = $currentDate->copy()->startOfMonth()->dayOfWeek;

        // Mengambil latihan dari database berdasarkan tanggal
        $trainings = OverallShot::where('user_id', Auth::user()->id)
            ->whereMonth('date', $currentDate->month)
            ->whereYear('date', $currentDate->year)
            ->get()
            ->groupBy(function ($training) {
                return Carbon::parse($training->date)->format('Y-m-d');
            });

        // Apply accuracy filter if provided
        if ($request->filled('filter_accuracy')) {
            switch ($request->filter_accuracy) {
                case 'high':
                    $query->where('totalaccuracy', '>', 75);
                    break;
                case 'medium':
                    $query->whereBetween('totalaccuracy', [50, 75]);
                    break;
                case 'low':
                    $query->where('totalaccuracy', '<', 50);
                    break;
            }
        }

        // Order by most recent
        $query->orderBy('created_at', 'desc');

        // Paginate the results
        $overallShot = $query->paginate(6);

        // Calculate stats for display
        $totalSessions = OverallShot::where('user_id', Auth::user()->id)->count();
        $avgAccuracy = round(OverallShot::where('user_id', Auth::user()->id)->avg('totalaccuracy'), 1) . '%';

        return view('Pemain.Dashboard', compact(
            'overallShot',
            'totalSessions',
            'avgAccuracy',
            'trainings',
            'daysInMonth',
            'firstDay',
            'currentDate'
        ));
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
