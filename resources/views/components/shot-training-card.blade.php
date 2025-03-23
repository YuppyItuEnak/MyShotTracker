<div class="bg-primary rounded-lg p-4 shadow-lg flex flex-col items-center justify-between">
    <!-- Title & Date -->
    <div class="text-center">
        <p class="text-xl font-bold text-white">Shoot Around</p>
        <p class="text-gray-400 text-sm">{{ $overallShot->date }}</p>
    </div>

    <!-- Accuracy Circle -->
    <div class="flex flex-col items-center mt-5">
        <div class="relative w-24 h-24">
            <svg class="w-24 h-24" viewBox="0 0 36 36">
                <circle cx="18" cy="18" r="16" stroke="gray" stroke-width="4" fill="none" />
                <circle cx="18" cy="18" r="16" stroke="#a3e635" stroke-width="4" fill="none"
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
            <p class="text-sm font-semibold text-grafik">Shot Count</p>
        </div>
        <div class="text-center">
            <p class="text-white font-bold text-lg">60 minutes</p>
            <p class="text-sm font-semibold text-grafik">Court Time</p>
        </div>
    </div>

    <!-- Court Image -->
    <img src="halfcourt.jpg" alt="Court Image" class="w-full mt-3 rounded-lg">

    <!-- Button -->
    <button class="w-full mt-4 bg-grafik text-black font-bold py-2 rounded-lg hover:bg-green-500 transition">
        See Detail
    </button>
</div>
