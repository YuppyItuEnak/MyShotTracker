<x-layout>
    <!-- SECTION DESKTOP -->
    <div class="container mx-auto py-6 max-w-7xl">
        <!-- Header Section with Improved Styling -->
        <div class="bg-gradient-to-r from-gray-900 to-black rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between mb-6">
                <div class="w-full md:w-1/2 mb-4 md:mb-0">
                    <h1 class="text-4xl font-extrabold text-white tracking-tight md:text-5xl lg:text-6xl">
                        Welcome to <br> <span class="text-grafik">MyShotTracker</span>
                    </h1>
                    <div class="grid grid-cols-2 gap-4 mt-6">
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md">
                            <p class="text-gray-400 text-sm">Total Training</p>
                            <p class="text-white text-2xl font-bold">{{ $totalSessions ?? 0 }}</p>
                        </div>
                        <div class="bg-gray-800 rounded-lg p-4 shadow-md">
                            <p class="text-gray-400 text-sm">Avg. Accuracy</p>
                            <p class="text-white text-2xl font-bold">{{ $avgAccuracy ?? '0%' }}</p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-1/2 flex justify-center">
                    <div class="bg-gray-800 text-white rounded-lg p-6 w-full max-w-md">
                        <div class="flex justify-between mb-4">
                            <a href="/index?date={{ $currentDate->copy()->subMonth()->format('Y-m') }}"
                                class="px-4 py-2 bg-blue-500 text-white rounded">  <|  </a>
                                    <h2 class="text-xl font-bold text-center">{{ $currentDate->format('F Y') }}</h2>
                                    <a href="/index?date={{ $currentDate->copy()->addMonth()->format('Y-m') }}"
                                        class="px-4 py-2 bg-blue-500 text-white rounded"> |> </a>
                        </div>
                        <div class="grid grid-cols-7 gap-2 mt-4 text-center">
                            @foreach (['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
                                <div class="font-semibold">{{ $day }}</div>
                            @endforeach
                            @for ($i = 0; $i < $firstDay; $i++)
                                <div></div>
                            @endfor
                            @for ($day = 1; $day <= $daysInMonth; $day++)
                                @php
                                    $dateString =
                                        $currentDate->format('Y-m') . '-' . str_pad($day, 2, '0', STR_PAD_LEFT);
                                    $hasTraining = isset($trainings[$dateString]);
                                @endphp
                                <div class="relative p-2 rounded cursor-pointer {{ $hasTraining ? 'hover:bg-blue-700' : 'hover:bg-blue-200' }}
                                     {{ request('filter_date') == $dateString ? 'bg-blue-600' : '' }}"
                                    onclick="showTrainings('{{ $dateString }}')">
                                    <span>{{ $day }}</span>
                                    @if ($hasTraining)
                                        <div class="flex justify-center mt-1">
                                            <span class="block w-2 h-2 bg-green-500 rounded-full"></span>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- My History Section with Improved Filter -->
        <div class="rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                <!-- Title with Icon -->
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-500 mr-2" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                            clip-rule="evenodd" />
                    </svg>
                    <h1 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white">
                        My Training History
                    </h1>
                </div>


                <!-- Filter Form - Added form tag with method and action -->
                <form id="filterForm" method="GET" action="{{ route('Overall.index') }}" class="w-full md:w-auto">
                    <div class="flex flex-wrap items-center gap-3 md:gap-4">
                        <!-- Date Range Filter -->
                        <div class="flex items-center">
                            <label class="text-white text-sm md:text-base font-medium mr-2">Date: </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input readonly name="filter_date" id="default-datepicker" type="text"
                                    class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                                    placeholder="Select Date on Calendar" value="{{ request('filter_date') }}">
                            </div>
                        </div>

                        <!-- Accuracy Filter -->
                        <div class="flex items-center">
                            <label class="text-white text-sm md:text-base font-medium mr-2">Accuracy: </label>
                            <select name="filter_accuracy"
                                class="bg-gray-800 border border-gray-700 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                                onchange="document.getElementById('filterForm').submit()">
                                <option value="" {{ request('filter_accuracy') == '' ? 'selected' : '' }}>Select Accuracy
                                </option>
                                <option value="high" {{ request('filter_accuracy') == 'high' ? 'selected' : '' }}>
                                    High
                                    (> 75%)</option>
                                <option value="medium" {{ request('filter_accuracy') == 'medium' ? 'selected' : '' }}>
                                    Medium (50-75%)</option>
                                <option value="low" {{ request('filter_accuracy') == 'low' ? 'selected' : '' }}>Low
                                    (
                                    < 50%)</option>
                            </select>
                        </div>

                        <!-- Added filter button -->
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg px-4 py-2.5 transition duration-300">
                            Apply Filters
                        </button>

                        <!-- Added reset button -->
                        <a href="{{ route('Overall.index') }}"
                            class="bg-gray-700 hover:bg-gray-600 text-white text-sm font-medium rounded-lg px-4 py-2.5 transition duration-300">
                            Reset
                        </a>
                    </div>

                    <!-- Hidden field for date if selected from calendar -->
                    @if (request()->has('date'))
                        <input type="hidden" name="date" value="{{ request('date') }}">
                    @endif

                    <!-- Keep current page when filtering -->
                    @if (request()->has('page'))
                        <input type="hidden" name="page" value="{{ request('page') }}">
                    @endif
                </form>
            </div>



            <!-- Cards Section with Improved Styling -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($overallShot as $shot)
                    <x-shot-training-card :overallShot="$shot"></x-shot-training-card>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-12 bg-gray-800 rounded-xl">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-500 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-xl text-gray-400 font-medium">No training sessions found with these filters</p>
                        <a href="{{ route('Overall.index') }}"
                            class="mt-4 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300 flex items-center">
                            Reset Filters
                        </a>
                    </div>
                @endforelse
            </div>

            <div class="mt-4">
                {{ $overallShot->links() }}
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Pastikan elemen datepicker ada di halaman
            const datepicker = document.getElementById('default-datepicker');
            if (datepicker) {
                // Jika menggunakan flatpickr
                flatpickr(datepicker, {
                    dateFormat: "Y-m-d",
                    altInput: true,
                    altFormat: "F j, Y",
                    theme: "dark",
                    onChange: function(selectedDates, dateStr) {
                        // Auto submit when date is selected
                        document.getElementById('filterForm').submit();
                    }
                });
            }

            // Auto-submit saat dropdown diubah
            const accuracyFilter = document.querySelector('select[name="filter_accuracy"]');
            if (accuracyFilter) {
                accuracyFilter.addEventListener('change', function() {
                    document.getElementById('filterForm').submit();
                });
            }
        });

        // Function to show trainings for a specific date
        function showTrainings(dateString) {
            // Set the filter_date value in the form
            const datepicker = document.getElementById('default-datepicker');
            if (datepicker) {
                datepicker.value = dateString;
            }

            // Submit the form to filter results
            document.getElementById('filterForm').submit();
        }
    </script>
</x-layout>
