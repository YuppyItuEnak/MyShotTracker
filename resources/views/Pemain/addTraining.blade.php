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
                    {{-- <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">


                    <!-- Date Input -->
                    <div class="mb-4">
                        <label class="block text-sm mb-2 text-white" for="date">Date:</label>
                        <input type="date" name="date" id="date"
                            class="w-full bg-gray-700 text-white px-4 py-2 rounded">
                    </div> --}}

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
                                        <option value="Top Of The Key">Freethrow</option>
                                    </select>
                                </div>

                                <div class="mb-4">
                                    <div class="w-full">
                                        <label class="block text-sm mb-2 text-white" for="attempt_0">Attempt</label>
                                        <input name="attempt"
                                            class="w-full bg-gray-700 text-white px-4 py-2 rounded attempt"
                                            id="attempt_0" type="number" min="0" />
                                    </div>
                                </div>
                                <div class="mb-4 flex">
                                    <div class="w-1/2 mr-2">
                                        <button type="submit"
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
        document.getElementById("finish-button").addEventListener("click", function() {
            fetch("http://192.168.18.34:8000/api/finish-training-session", {
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
        });

        // polling untuk status aktif latihan
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
                })
                .catch(() => {
                    document.getElementById('training-status').innerHTML = `
                        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md p-6 mt-6 text-center text-gray-500">
                            Tidak ada sesi aktif.
                        </div>`;
                });
        }

        // Jalankan polling setiap 2 detik
        setInterval(fetchTrainingStatus, 2000);
        fetchTrainingStatus();
    </script>


</x-layout>
