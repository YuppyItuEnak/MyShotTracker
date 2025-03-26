<x-pelatih-layout>
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

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
        <table class="w-full text-sm text-left rtl:text-right  text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 text-center uppercase bg-primary border-secondary dark:bg-primary dark:border-secondary dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Shooting Around
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Shot Made
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Attempt
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Accuracy
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                <tr
                    class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="col" class="p-4">
                        {{ $overallShot->id }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ $overallShot->date }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Shooting Around
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ $overallShot->totalmade }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        {{ $overallShot->totalattempt }}
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <div class="flex flex-col items-center mt-5">
                            <div class="relative w-24 h-24">
                                <svg class="w-24 h-24" viewBox="0 0 36 36">
                                    <circle cx="18" cy="18" r="16" stroke="gray" stroke-width="4"
                                        fill="none" />
                                    <circle cx="18" cy="18" r="16" stroke="#a3e635" stroke-width="4"
                                        fill="none" stroke-dasharray="100, 100"
                                        stroke-dashoffset="{{ 100 - $overallShot->totalaccuracy }}"></circle>
                                </svg>
                                <span
                                    class="absolute inset-0 flex flex-col items-center justify-center text-white font-bold text-lg">
                                    {{ $overallShot->totalaccuracy }}%
                                    <span class="text-sm text-gray-300">Overall</span>
                                </span>
                            </div>
                        </div>
                    </th>
                    <td class="flex items-center px-6 py-4">
                        {{-- @foreach ($shotTraining as $shot) --}}
                        <a href="{{ route('pelatih.showDetailShot', ['id' => $overallShot->id]) }}"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                            View Detail
                        </a>
                        {{-- @endforeach --}}
                        <a href="#"
                            class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</a>
                    </td>
                </tr>


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
