{{-- <x-layout>
    <div class="flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-white tracking-tight md:text-5xl lg:text-6xl mb-5">
            Report Progress
        </h1>
    </div>

    <div class="w-full h-auto sm:h-[250px] md:h-[300px] border rounded">
        <canvas class="p-4" id="progressChart"></canvas>
    </div>


    <div class="flex flex-row justify-between">
        <div class=" flex flex-row mt-5 mb-5">
            <button onclick="changeWeek(-1)" class="border rounded bg-primary p-4 text-white font-bold italic">Previous Week</button>
        </div>

        <div class=" flex flex-row mt-5 mb-5">
            <button onclick="changeWeek(1)" class="border rounded bg-grafik p-4 text-black font-bold italic">Next Week</button>
        </div>
    </div>




    <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4 mt-5 mb-5">
        <h1 class="text-white text-sm md:text-2xl tracking-tight font-bold">
            Filter by Date:
        </h1>


        <div class="relative max-w-sm">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                </svg>
            </div>
            <input datepicker id="default-datepicker" type="text"
                class="bg-black border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-black dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Select date">
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
        @foreach ($overallShot as $overall)
            <x-shot-training-card :overallShot="$overall"></x-shot-training-card>
        @endforeach
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

        // Fungsi untuk mengganti chart ke minggu lain
        function changeWeek(direction) {
            currentWeekIndex += direction;
            if (currentWeekIndex < 0) currentWeekIndex = 0;
            if (currentWeekIndex >= Object.keys(weeks).length) currentWeekIndex = Object.keys(weeks).length - 1;
            updateChart(currentWeekIndex);
        }
    </script>







</x-layout> --}}
