<x-pelatih-layout>
    <a href="javascript:history.back()"
        class="inline-flex items-center px-4 py-2 mb-5 text-sm font-medium text-black bg-grafik rounded-lg shadow-md hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back
    </a>

    <h1 class="text-white mb-5 text-2xl font-bold italic">Shoot Training Date: <span
            class="text-grafik">{{ $overallShot->date }}</span></h1>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
        <table class="w-full text-sm text-left rtl:text-right  text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase text-center bg-primary border-secondary dark:bg-primary dark:border-secondary dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Location
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Shot Made
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Attempt
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Accuracy
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($shotTraining as $index => $shot)
                    <tr
                        class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="col" class="p-4">
                            {{ $index + 1 }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ $shot->location }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ $shot->shotmade }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ $shot->attempt }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex flex-col items-center mt-5">
                                <div class="relative w-24 h-24">
                                    <svg class="w-24 h-24" viewBox="0 0 36 36">
                                        <!-- Background Circle -->
                                        <circle cx="18" cy="18" r="16" stroke="gray" stroke-width="4"
                                            fill="none" />
                                        <!-- Progress Circle -->
                                        <circle cx="18" cy="18" r="16" stroke="#a3e635" stroke-width="4"
                                            fill="none" stroke-dasharray="100, 100"
                                            stroke-dashoffset="{{ 100 - $shot->accuracy }}">
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
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-pelatih-layout>
