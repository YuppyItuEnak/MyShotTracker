<div class="bg-primary rounded-lg p-4 shadow-lg flex flex-col items-center justify-between">
    <!-- Title & Date -->
    <div class="text-center">
        <p class="text-xl font-bold text-white">{{ $overallShot->training_name ?? 'Shoot Around' }}</p>
        <p class="text-gray-400 text-sm">{{ $overallShot->date }}</p>
    </div>

    <!-- Accuracy Circle -->
    <div class="flex flex-col items-center mt-5">
        <div class="relative w-24 h-24">
            <svg class="w-24 h-24" viewBox="0 0 36 36">
                <circle cx="18" cy="18" r="16" stroke="gray" stroke-width="4" fill="none" />
                <circle cx="18" cy="18" r="16" stroke="#C7F000" stroke-width="4" fill="none"
                    stroke-dasharray="100, 100" stroke-dashoffset="{{ 100 - $overallShot->totalaccuracy }}"></circle>
            </svg>
            <span class="absolute inset-0 flex flex-col items-center justify-center text-white font-bold text-lg">
                {{ $overallShot->totalaccuracy }}%
                <span class="text-sm text-gray-300">Overall</span>
            </span>
        </div>
    </div>

    <!-- Stats -->
    <div class="flex flex-row justify-start gap-6 text-gray-400 mt-3">
        <div class="text-center">
            <p class="text-white text-lg font-bold">{{ $overallShot->totalmade }} / {{ $overallShot->totalattempt }}</p>
            <p class="text-sm font-semibold">Shot Count</p>
        </div>
        <div class="text-center">
            <p class="text-white font-bold text-lg">{{ $overallShot->court_time ?? '60' }} minutes</p>
            <p class="text-sm font-semibold">Court Time</p>
        </div>
    </div>

    <!-- Court Image with Shot Areas Overlay -->
    <div class="relative w-full mt-3">
        <!-- Court Base Image -->
        <svg class="w-full rounded-lg" viewBox="0 0 500 350" xmlns="http://www.w3.org/2000/svg">
            <!-- Court background -->
            <rect x="0" y="0" width="500" height="350" fill="#e0e0e0" stroke="#333" stroke-width="2" />

            <!-- Three point line -->
            <path d="M 85,320 A 140,140 0 0 1 415,320" fill="none" stroke="#333" stroke-width="2" />

            <!-- Corner three line markers -->
            <line x1="85" y1="350" x2="85" y2="290" stroke="#333" stroke-width="2" />
            <line x1="415" y1="350" x2="415" y2="290" stroke="#333" stroke-width="2" />

            <!-- Key/paint area -->
            <rect x="190" y="250" width="120" height="100" fill="none" stroke="#333" stroke-width="2" />

            <!-- Free throw line -->
            <line x1="190" y1="250" x2="310" y2="250" stroke="#333" stroke-width="2" />

            <!-- Free throw circle -->
            <circle cx="250" cy="250" r="60" fill="none" stroke="#333" stroke-width="2"
                stroke-dasharray="5,5" />

            <!-- Restricted area semicircle -->
            <path d="M 225,350 A 25,25 0 0 1 275,350" fill="none" stroke="#333" stroke-width="2" />

            <!-- Backboard -->
            <line x1="225" y1="345" x2="275" y2="345" stroke="#333" stroke-width="3" />

            <!-- Basket -->
            <circle cx="250" cy="345" r="5" fill="none" stroke="#333" stroke-width="2" />

            <!-- Lane spaces/hash marks -->
            <line x1="190" y1="275" x2="197" y2="275" stroke="#333" stroke-width="2" />
            <line x1="190" y1="300" x2="197" y2="300" stroke="#333" stroke-width="2" />
            <line x1="190" y1="325" x2="197" y2="325" stroke="#333" stroke-width="2" />

            <line x1="310" y1="275" x2="303" y2="275" stroke="#333" stroke-width="2" />
            <line x1="310" y1="300" x2="303" y2="300" stroke="#333" stroke-width="2" />
            <line x1="310" y1="325" x2="303" y2="325" stroke="#333" stroke-width="2" />

            @php
                // Group shot_trainings by location and calculate average accuracy
                $locationData = [];
                $shotTrainings = $overallShot->shotTrainings ?? collect();

                foreach ($shotTrainings as $training) {
                    if (!isset($locationData[$training->location])) {
                        $locationData[$training->location] = [
                            'total_made' => 0,
                            'total_attempt' => 0,
                            'accuracy' => 0,
                        ];
                    }

                    $locationData[$training->location]['total_made'] += $training->shotmade;
                    $locationData[$training->location]['total_attempt'] += $training->attempt;
                }

                // Calculate accuracy for each location
                foreach ($locationData as $location => $data) {
                    if ($data['total_attempt'] > 0) {
                        $locationData[$location]['accuracy'] = round(
                            ($data['total_made'] / $data['total_attempt']) * 100,
                            0,
                        );
                    }
                }

                $locationPaths = [
                    'Right Corner' => [
                        'path' => 'M 410,350 L 500,350 L 500,290 L 410,290 Z',
                        'labelX' => 455,
                        'labelY' => 320,
                    ],
                    'Left Corner' => [
                        'path' => 'M 0,350 L 90,350 L 90,290 L 0,290 Z',
                        'labelX' => 45,
                        'labelY' => 320,
                    ],
                    'Right Wing' => [
                        'path' => 'M 380,250 L 500,250 L 500,150 L 380,150 Z',
                        'labelX' => 430,
                        'labelY' => 200,
                    ],
                    'Left Wing' => [
                        'path' => 'M 120,250 L 0,250 L 0,150 L 120,150 Z',
                        'labelX' => 70,
                        'labelY' => 200,
                    ],
                    'Top' => [
                        'path' => 'M 150,150 L 350,150 L 350,90 L 150,90 Z',
                        'labelX' => 250,
                        'labelY' => 120,
                    ],
                    'Right Elbow' => [
                        'path' => 'M 310,270 L 370,270 L 370,230 L 310,230 Z',
                        'labelX' => 340,
                        'labelY' => 250,
                    ],
                    'Left Elbow' => [
                        'path' => 'M 190,270 L 130,270 L 130,230 L 190,230 Z',
                        'labelX' => 160,
                        'labelY' => 250,
                    ],
                    'Top Of The Key' => [
                        'path' => 'M 220,200 L 280,200 L 280,160 L 220,160 Z',
                        'labelX' => 250,
                        'labelY' => 180,
                    ],
                    'Freethrow' => [
                        'path' => 'M 220,260 L 280,260 L 280,220 L 220,220 Z',
                        'labelX' => 250,
                        'labelY' => 240,
                    ],
                    'Right Short Corner' => [
                        'path' => 'M 330,350 L 390,350 L 390,310 L 330,310 Z',
                        'labelX' => 360,
                        'labelY' => 330,
                    ],
                    'Left Short Corner' => [
                        'path' => 'M 170,350 L 110,350 L 110,310 L 170,310 Z',
                        'labelX' => 140,
                        'labelY' => 330,
                    ],
                ];
            @endphp

            <!-- Render each location with appropriate color and accuracy label -->
            @foreach ($locationPaths as $location => $pathData)
                @php
                    $accuracy = $locationData[$location]['accuracy'] ?? 0;
                    // Reversed color logic to match legend
                    if ($accuracy < 50) {
                        $color = '#ef4444'; // Green for improvement areas
                    } elseif ($accuracy < 65) {
                        $color = '#f97316'; // Yellow for average
                    } elseif ($accuracy < 80) {
                        $color = '#eab308'; // Orange for good
                    } else {
                        $color = '#C7F000'; // Red for excellent
                    }
                    $opacity = $accuracy > 0 ? 0.9 : 0;
                @endphp

                <path d="{{ $pathData['path'] }}" fill="{{ $color }}" fill-opacity="{{ $opacity }}" stroke="#333"
                    stroke-width="1" />

                @if ($accuracy > 0)
                    <text x="{{ $pathData['labelX'] }}" y="{{ $pathData['labelY'] }}" text-anchor="middle"
                        fill="white" font-weight="bold" font-size="14">
                        {{ $accuracy }}%
                    </text>
                @endif
            @endforeach
        </svg>

        <!-- Color Legend -->
        <div class="flex justify-center mt-2">
            <div class="flex space-x-2 text-xs">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-500 mr-1"></div>
                    <span class="text-white">0-49%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-orange-500 mr-1"></div>
                    <span class="text-white">50-64%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-yellow-500 mr-1"></div>
                    <span class="text-white">65-79%</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-grafik mr-1"></div>
                    <span class="text-white">80-100%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Button -->
    <a href="{{ route('training.show', ['id' => $overallShot->id]) }}"
        class="w-full mt-4 bg-grafik text-black text-center font-bold py-2 rounded-lg hover:bg-green-400 transition">
        See Detail
    </a>
</div>
