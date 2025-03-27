<x-pelatih-layout>
    <a href="javascript:history.back()"
        class="inline-flex items-center px-4 py-2 mb-5 text-sm font-medium text-black bg-grafik rounded-lg shadow-md hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back
    </a>


    <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-5">
        <!-- Bagian Kiri: Profil Pemain -->
        <div class="flex flex-col md:flex-row gap-6 items-center text-center md:text-left">
            <img class="w-32 h-32 md:w-40 md:h-40 rounded-full object-cover"
                src="{{ asset('storage/' . $user->image) }}" alt="">

            <div class="flex flex-col">
                <h1 class="text-lg md:text-xl font-extrabold text-white tracking-tight mb-2 md:mb-5">
                    {{ $user->name }}
                </h1>
                <h1 class="text-sm md:text-lg font-extrabold text-white tracking-tight">
                    {{ $user->email }}
                </h1>
            </div>
        </div>

        <!-- Bagian Kanan: Training Count -->
        <div class="border border-secondary p-4 bg-primary flex flex-col justify-center items-center w-full md:w-auto">
            <h1 class="text-2xl md:text-3xl font-extrabold text-center text-white tracking-tight">
                {{ $trainingcount }}
            </h1>
            <h1 class="text-sm md:text-lg font-extrabold text-center text-grafik tracking-tight">
                Training Count
            </h1>
        </div>
    </div>

    <div class="w-full h-auto sm:h-[250px] md:h-[300px] border rounded">
        <canvas class="p-4" id="progressChart"></canvas>
    </div>

    <div class="flex flex-row justify-between">
        <div class=" flex flex-row mt-5 mb-5">
            <button onclick="changeWeek(-1)" class="border rounded bg-primary p-4 text-white font-bold italic">Previous
                Week</button>
        </div>

        <div class=" flex flex-row mt-5 mb-5">
            <button onclick="changeWeek(1)" class="border rounded bg-grafik p-4 text-black font-bold italic">Next
                Week</button>
        </div>
    </div>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-center text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-4 py-3 md:px-6">Date</th>
                    <th scope="col" class="px-4 py-3 md:px-6">Shooting Around</th>
                    <th scope="col" class="px-4 py-3 md:px-6">Total Shot Made</th>
                    <th scope="col" class="px-4 py-3 md:px-6">Total Attempt</th>
                    <th scope="col" class="px-4 py-3 md:px-6">Total Accuracy</th>
                    <th scope="col" class="px-4 py-3 md:px-6 text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($overallShot as $shot)
                    <tr
                        class="odd:bg-white even:bg-gray-50 text-center items-center dark:odd:bg-gray-900 dark:even:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3 md:px-6">{{ $shot->date }}</td>
                        <th scope="row"
                            class="px-4 py-3 md:px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            Shooting Around
                        </th>
                        <td class="px-4 py-3 md:px-6">{{ $shot->totalmade }}</td>
                        <td class="px-4 py-3 md:px-6">{{ $shot->totalattempt }}</td>
                        <td class="px-4 py-3 md:px-6">{{ $shot->totalaccuracy }}</td>
                        <td class="px-4 py-3 md:px-6 text-center">
                            <a href="{{ route('pelatih.showDetailShot', $shot->id) }}"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var progressChart;

        function renderChart(labels, data, weekNumber) {
            var ctx = document.getElementById('progressChart').getContext('2d');

            // Hapus instance sebelumnya jika ada
            if (progressChart) {
                progressChart.destroy();
            }

            progressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Shooting Progress - Week ' + weekNumber,
                        data: data,
                        backgroundColor: '#CFFF04',
                        borderRadius: 6,
                        borderSkipped: false,
                        barThickness: 30,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#CFFF04',
                                font: {
                                    weight: 'bold'
                                }
                            },
                        },
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                stepSize: 20,
                                color: 'white',
                                font: {
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                color: 'rgba(255, 255, 255, 0.2)'
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }

        var weeks = @json($weeks);
        var currentWeekIndex = Object.keys(weeks).length - 1; // Tampilkan minggu terbaru

        function updateChart(weekIndex) {
            let weekKey = Object.keys(weeks)[weekIndex];
            if (weeks[weekKey]) {
                let labels = weeks[weekKey].map(item => item.label);
                let data = weeks[weekKey].map(item => item.value);
                renderChart(labels, data, weekKey);
            }
        }

        updateChart(currentWeekIndex);

        function changeWeek(direction) {
            currentWeekIndex += direction;
            if (currentWeekIndex < 0) currentWeekIndex = 0;
            if (currentWeekIndex >= Object.keys(weeks).length) currentWeekIndex = Object.keys(weeks).length - 1;
            updateChart(currentWeekIndex);
        }
    </script>


</x-pelatih-layout>
