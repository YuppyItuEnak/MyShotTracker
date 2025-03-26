<x-layout>
    <div>
        <h1 class="text-4xl italic font-extrabold text-white tracking-tight md:text-5xl lg:text-6xl mb-5">
            Shooting Training Detail
        </h1>
    </div>
    <div class="flex justify-center">
        <div>
            <img class="w-full max-w-2xl rounded-lg shadow-xl mb-6" src="{{ asset('shotlocation.jpg') }}"
                alt="Basketball court with shot locations marked">
        </div>
    </div>
    <div class="mt-5 mb-5">
        <div class="flex flex-col items-center gap-4">
            <div
                class="bg-grafik rounded-lg p-4 shadow-lg w-full max-w-sm min-h-64 flex flex-col items-center justify-between">
                <!-- Accuracy Circle -->
                <div class="flex flex-col items-center mt-2">
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24" viewBox="0 0 36 36">
                            <!-- Background Circle -->
                            <circle cx="18" cy="18" r="16" stroke="gray" stroke-width="4"
                                fill="none" />
                            <!-- Progress Circle -->
                            <circle cx="18" cy="18" r="16" stroke="#252525" stroke-width="4"
                                fill="none" stroke-dasharray="100, 100"
                                stroke-dashoffset="{{ 100 - $overallShot->totalaccuracy }}">
                            </circle>
                        </svg>
                        <!-- Percentage Text -->
                        <span
                            class="absolute inset-0 flex flex-col items-center justify-center text-black font-bold text-lg">
                            {{ $overallShot->totalaccuracy }}%
                            <span class="text-sm text-black">Overall</span>
                        </span>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center">
                    <p class="text-xl font-bold text-black">Shoot Around</p>
                    <p class="text-black text-sm">{{ $overallShot->date }}</p>
                </div>

                <!-- Stats -->
                <div class="flex flex-row justify-center gap-6 text-gray-400">
                    <!-- Shot Count -->
                    <div class="text-center">
                        <p class="text-black text-lg font-bold">{{ $overallShot->totalmade }} /
                            {{ $overallShot->totalattempt }}</p>
                        <p class="text-sm font-semibold text-black">Shot Count</p>
                    </div>
                    <!-- Court Time -->
                    <div class="text-center">
                        <p class="text-black text-lg font-bold">60 minutes</p>
                        <p class="text-sm font-semibold text-black">Court Time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
        @foreach ($shotTraining as $shot)
            <div class="bg-primary rounded-lg p-4 shadow-lg flex flex-col items-center justify-between">
                <!-- Accuracy Circle -->
                <div class="flex flex-col items-center mt-5">
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24" viewBox="0 0 36 36">
                            <!-- Background Circle -->
                            <circle cx="18" cy="18" r="16" stroke="gray" stroke-width="4"
                                fill="none" />
                            <!-- Progress Circle -->
                            <circle cx="18" cy="18" r="16" stroke="#a3e635" stroke-width="4"
                                fill="none" stroke-dasharray="100, 100" stroke-dashoffset="{{ 100 - $shot->accuracy }}">
                            </circle>
                        </svg>
                        <!-- Percentage Text -->
                        <span
                            class="absolute inset-0 flex flex-col items-center justify-center text-white font-bold text-lg">
                            {{ $shot->accuracy }}%
                            <span class="text-sm text-gray-300">Overall</span>
                        </span>
                    </div>
                </div>

                <!-- Title -->
                <div class="text-center mt-5">
                    <p class="text-xl font-bold text-white">{{ $shot->location }}</p>
                </div>

                <!-- Stats -->
                <div class="flex flex-row justify-center gap-6 text-gray-400 mt-3">
                    <!-- Shot Count -->
                    <div class="text-center">
                        <p class="text-white text-lg font-bold">{{ $shot->shotmade }} / {{ $shot->attempt }}</p>
                        <p class="text-sm font-semibold text-grafik">Shot Count</p>
                    </div>
                    <!-- Court Time -->
                    <div class="text-center">
                        <p class="text-white text-lg font-bold">60 minutes</p>
                        <p class="text-sm font-semibold text-grafik">Court Time</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-layout>
