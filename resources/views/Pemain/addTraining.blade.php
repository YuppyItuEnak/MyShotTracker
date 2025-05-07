<x-layout>
    <div class="flex flex-row justify-between items-center p-6">
        <div>
            <h1 class="text-4xl italic font-extrabold text-white tracking-tight md:text-5xl lg:text-6xl">
                Shoot Around
            </h1>
        </div>
        <div class="flex items-center">
            <button class="bg-gray-700 text-white px-5 py-2 rounded flex items-center gap-2 ml-5">
                <p class="italic font-bold">Info</p>
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="10" stroke="#C7F000" stroke-width="1.5"></circle>
                    <path d="M12 17V11" stroke="#C7F000" stroke-width="1.5" stroke-linecap="round"></path>
                    <circle cx="12" cy="8" r="1" fill="#C7F000"></circle>
                </svg>
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-2 p-4">
        <div class="lg:col-span-2">
            <h2 class="text-2xl italic font-extrabold text-white tracking-tight md:text-3xl lg:text-4xl">
                Shot <span class="text-grafik">Location</span>
            </h2>
            <div class="flex justify-center">
                <div>
                    <img class="w-full max-w-2xl rounded-lg shadow-xl mb-6" src="{{ asset('shotlocation.jpg') }}"
                        alt="Basketball court with shot locations marked">
                </div>
            </div>

            <div>
                <h1 class="text-2xl font-bold italic text-white">Shot Training</h1>
                <form id="training-form" action="{{ route('training.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <!-- Tempat Form Training -->
                    <div id="shooting-location-container">
                        <div id="shot-container">
                            <div class="relative border rounded p-5 mb-2 font-bold italic shot-form">
                                <div class="mb-4">
                                    <label class="block text-sm mb-2 text-white" for="location_0"
                                        name="location">Location</label>
                                    <select name="location"
                                        class="w-full bg-gray-700 text-white px-4 py-2 rounded location-select"
                                        id="location_0">
                                        <option value="">Choose Shooting Location</option>
                                        <option value="Right Corner">Right Corner</option>
                                        <option value="Left Corner">Left Corner</option>
                                        <option value="Right Wing">Right wing</option>
                                        <option value="Left Wing">Left wing</option>
                                        <option value="Top">Top</option>
                                        <option value="Right Short Corner">Right Short Corner</option>
                                        <option value="Left Short Corner">Left Short Corner</option>
                                        <option value="Right Elbow">Right Elbow</option>
                                        <option value="Left Elbow">Left Elbow</option>
                                        <option value="Top Of The Key">Top of The Key</option>
                                        <option value="Freethrow">Freethrow</option>
                                    </select>
                                </div>

                                <div class="mb-4 flex">
                                    <div class="w-1/2 mr-2">
                                        <label class="block text-sm mb-2 text-white" for="attempt_0">Attempt</label>
                                        <input name="attempt"
                                            class="w-full bg-gray-700 text-white px-4 py-2 rounded attempt"
                                            id="attempt_0" type="number" min="0" />
                                    </div>
                                    <div class="w-1/2">
                                        <label for="duration" class="block mb-2 text-sm font-medium text-white">Durasi
                                            Latihan</label>
                                        <div class="flex">
                                            <div class="w-1/2 mr-1">
                                                <input type="number" id="minutes" min="0" max="59"
                                                    placeholder="Menit"
                                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg w-full p-2.5" />
                                            </div>
                                            <div class="w-1/2">
                                                <input type="number" id="seconds" min="0" max="59"
                                                    placeholder="Detik"
                                                    class="bg-gray-700 border border-gray-600 text-white text-sm rounded-lg w-full p-2.5" />
                                            </div>
                                            <input type="hidden" name="duration" id="duration_value" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Stopwatch Display -->
                                <div class="mb-4">
                                    <div id="stopwatch-container" class="hidden">
                                        <label class="block text-sm mb-2 text-white">Waktu Berjalan</label>
                                        <div class="bg-gray-800 border border-gray-700 rounded-lg p-4 text-center">
                                            <span id="stopwatch-display"
                                                class="text-3xl font-bold text-grafik">00:00</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-4 flex">
                                    <div class="w-1/2 mr-2">
                                        <button type="button" id="start-button"
                                            class="bg-grafik text-black font-bold italic px-4 py-2 rounded w-full">
                                            Start
                                        </button>
                                    </div>
                                    <div class="w-1/2">
                                        <button type="button" id="finish-button"
                                            class="bg-gray-500 text-white font-bold italic px-4 py-2 rounded w-full">
                                            Finish
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Status Real-time -->
                <div class="status-box" id="training-status">
                    <p>Memuat status latihan...</p>
                </div>

                <!-- Hasil Status  -->
                <div class="status-box" id="training-result">
                    <p>Memuat status latihan...</p>
                </div>
            </div>
        </div>
    </div>

    <script>

        const startButton = document.getElementById('start-button');
        const finishButton = document.getElementById('finish-button');
        const trainingForm = document.getElementById('training-form');
        const minutesInput = document.getElementById('minutes');
        const secondsInput = document.getElementById('seconds');
        const durationValue = document.getElementById('duration_value');
        const stopwatchContainer = document.getElementById('stopwatch-container');
        const stopwatchDisplay = document.getElementById('stopwatch-display');

        // Variables untuk stopwatch
        let totalSeconds = 0;
        let initialTotalSeconds = 0; // menyimpan initial time untuk menghitung elapsed time
        let countdownInterval = null;
        let isRunning = false;
        let timerExpired = false; // penanda untuk metracking waktu telah berakhir atau belom

        // Format time dengan MM:SS
        function formatTime(totalSecs) {
            const minutes = Math.floor(totalSecs / 60);
            const seconds = totalSecs % 60;
            return `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
        }

        // validasi input untuk memastikan variable yang dimasukan valid
        function validateTimeInputs() {
            let mins = parseInt(minutesInput.value) || 0;
            let secs = parseInt(secondsInput.value) || 0;

            // mengubah detika jika melebihi 59
            if (secs > 59) {
                mins += Math.floor(secs / 60);
                secs = secs % 60;
                secondsInput.value = secs;
                minutesInput.value = mins;
            }

            // Return total seconds
            return (mins * 60) + secs;
        }

        // Start stopwatch countdown
        function startStopwatch() {
            if (isRunning) return;

            totalSeconds = validateTimeInputs();
            initialTotalSeconds = totalSeconds; // menyimpan initial total seconds
            timerExpired = false; // Reset timer expired flag

            // Check klo waktu dispesifikasikan
            if (totalSeconds <= 0) {
                alert('Please enter a valid time (at least 1 second)');
                return false;
            }

            // Format duration untuk database menjadi "MM:SS"
            const minutes = parseInt(minutesInput.value) || 0;
            const seconds = parseInt(secondsInput.value) || 0;
            const formattedDuration = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

            // Set duration value untuk form submission dalam format MM:SS
            durationValue.value = formattedDuration;

            // Show stopwatch container
            stopwatchContainer.classList.remove('hidden');

            // Update display immediately
            stopwatchDisplay.textContent = formatTime(totalSeconds);

            // Start countdown
            isRunning = true;
            startButton.classList.add('bg-gray-500');
            startButton.classList.remove('bg-grafik');

            countdownInterval = setInterval(() => {
                totalSeconds--;
                stopwatchDisplay.textContent = formatTime(totalSeconds);

                if (totalSeconds <= 0) {
                    // Time's up
                    clearInterval(countdownInterval);
                    isRunning = false;
                    timerExpired = true; // Set timer expired flag
                    stopwatchDisplay.textContent = "00:00";

                    // Alert user
                    alert("Time's up! Training session ended.");

                    // Update server that time has expired (automatically end training session)
                    updateTimerExpiredStatus();

                    // Reset UI
                    resetStopwatch();
                }
            }, 1000);

            return true;
        }

        // Stop the stopwatch
        function stopStopwatch() {
            if (!isRunning) return;

            clearInterval(countdownInterval);
            isRunning = false;

            // Calculate elapsed time and update duration value
            const elapsedSeconds = initialTotalSeconds - totalSeconds;
            const elapsedMinutes = Math.floor(elapsedSeconds / 60);
            const remainingSeconds = elapsedSeconds % 60;
            const elapsedFormatted =
                `${elapsedMinutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;

            // Update the duration_value to reflect actual elapsed time
            durationValue.value = elapsedFormatted;

            // Reset UI
            startButton.classList.remove('bg-gray-500');
            startButton.classList.add('bg-grafik');

            console.log(`Training stopped with elapsed time: ${elapsedFormatted}`);
        }

        // Reset the stopwatch
        function resetStopwatch() {
            stopStopwatch();
            stopwatchDisplay.textContent = "00:00";
            startButton.classList.remove('bg-gray-500');
            startButton.classList.add('bg-grafik');
        }

        // Enhanced start button functionality
        startButton.addEventListener("click", function() {
            const location = document.querySelector('.location-select').value;
            const attempt = document.querySelector('.attempt').value;

            if (!location) {
                alert('Silakan pilih lokasi tembakan');
                return;
            }

            if (!attempt || attempt <= 0) {
                alert('Silakan masukkan jumlah attempt');
                return;
            }

            // Start the stopwatch and continue with form submission if successful
            if (startStopwatch()) {
                const formData = new FormData(trainingForm);
                fetch(trainingForm.action, {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Training session started:', data);
                        // Start polling for status updates automatically
                        fetchTrainingStatus();
                    })
                    .catch(error => console.error('Error starting training:', error));
            }
        });

        finishButton.addEventListener("click", function() {
            // Stop the stopwatch
            stopStopwatch();

            fetch("/api/finish-training-session", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    alert("Sesi latihan diselesaikan!");
                    console.log(data);
                    window.location.href = '/training-status-page';
                })
                .catch(error => console.error("Error:", error));

            // Hide stopwatch container
            stopwatchContainer.classList.add('hidden');
        });

        // Add input validation to prevent negative numbers and non-numeric input
        minutesInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (parseInt(this.value) > 59) this.value = '59';
            if (this.value.startsWith('0') && this.value.length > 1) this.value = this.value.substring(1);
        });

        secondsInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
            if (parseInt(this.value) > 59) this.value = '59';
            if (this.value.startsWith('0') && this.value.length > 1) this.value = this.value.substring(1);
        });

        // Function untuk update status latihan jika timer sudah habis
        function updateTimerExpiredStatus() {
            fetch("/api/update-timer-status", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        timer_expired: true
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Timer status updated:", data);
                    // Reload training status untuk menampilkan session sudah berakhir
                    fetchTrainingStatus();
                })
                .catch(error => console.error("Error updating timer status:", error));
        }

        // Function untuk check jika shotmade == attempt dan timer berhenti
        function checkShotCompletion(data) {
            if (data && data.shotmade && data.attempt) {
                // Check jika shotmade == attempt atau lebih
                if (parseInt(data.shotmade) >= parseInt(data.attempt) && isRunning) {
                    // shotmade == attempt maka timer automatis stop
                    stopStopwatch();
                    alert("Shot target reached! Training complete.");

                    // Submit elapsed time ke server
                    updateCompletedTrainingTime();

                    // sembunyikan stopwatch container
                    stopwatchContainer.classList.add('hidden');
                }
            }
        }

        // Function to update server with elapsed time when shots are completed
        function updateCompletedTrainingTime() {
            const elapsedSeconds = initialTotalSeconds - totalSeconds;
            const elapsedMinutes = Math.floor(elapsedSeconds / 60);
            const remainingSeconds = elapsedSeconds % 60;
            const elapsedFormatted =
                `${elapsedMinutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;

            fetch("/api/update-training-time", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        duration: elapsedFormatted
                    })
                })
                .then(response => response.json())
                .then(data => {
                    console.log("Training time updated:", data);
                })
                .catch(error => console.error("Error updating training time:", error));
        }

        // Polling for active training status
        function fetchTrainingStatus() {
            fetch('/api/training-status')
                .then(res => res.json())
                .then(data => {
                    const html = `
                <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6 mt-6">
                    <h3 class="text-2xl font-bold mb-4 text-gray-800">Status Sesi Latihan</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Lokasi:</span>
                            <span class="text-gray-900">${data.location}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Target Attempt:</span>
                            <span class="text-gray-900">${data.attempt}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium text-gray-700">Jumlah Dihitung:</span>
                            <span class="text-gray-900">${data.shotmade}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="font-medium text-gray-700">Status:</span>
                            ${data.is_active
                                ? `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>`
                                : `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Selesai</span>`}
                        </div>
                    </div>
                </div>
            `;
                    document.getElementById('training-status').innerHTML = html;

                    // If session is not active anymore, hide stopwatch and reset
                    if (!data.is_active && isRunning) {
                        stopStopwatch();
                        stopwatchContainer.classList.add('hidden');
                    }

                    // Check if we've reached our shot target
                    if (isRunning) {
                        checkShotCompletion(data);
                    }
                })
                .catch(() => {
                    document.getElementById('training-status').innerHTML = `
                <div class="max-w-md mx-auto bg-white rounded-xl shadow-md p-6 mt-6 text-center text-gray-500">
                    Tidak ada sesi aktif.
                </div>`;
                });
        }

        // Run polling every 2 seconds
        setInterval(fetchTrainingStatus, 2000);
        fetchTrainingStatus();
    </script>
</x-layout>
