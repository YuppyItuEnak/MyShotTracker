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
                <form action="{{ route('pemain.store') }}" method="POST" enctype="multipart/form-data">
                    @method('POST')
                    @csrf

                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

                    <!-- Date Input -->
                    <div class="mb-4">
                        <label class="block text-sm mb-2 text-white" for="date">Date:</label>
                        <div class="flex flex-row justify-between items-center">
                            <input type="date" name="date" id="date"
                                class="w-full bg-gray-700 text-white px-4 py-2 rounded" >
                        </div>
                    </div>

                    <!-- Container untuk Shooting Location -->
                    <div id="shooting-location-container">
                        <x-add-training-form></x-add-training-form> <!-- Form pertama -->
                    </div>

                    <!-- Tombol Tambah Form -->
                    <button type="button" id="add-location"
                        class="bg-gray-700 text-white px-4 py-2 rounded w-full flex items-center justify-center mt-4">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add Shooting Location
                    </button>

                    <!-- Submit Form -->
                    <button type="submit" name="submit"
                        class="bg-grafik text-black font-bold italic px-4 py-2 rounded w-full flex items-center justify-center mt-4">
                        Submit
                    </button>
                </form>
            </div>
        </div>


    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("shooting-location-container");
            const addButton = document.getElementById("add-location");

            let shotIndex = 0; // Index untuk form yang ditambahkan

            // Fungsi untuk menambahkan form baru
            function addShotForm() {
                shotIndex++; // Increment index setiap form baru ditambahkan

                // Clone form pertama yang ada di dalam container
                const newForm = container.firstElementChild.cloneNode(true);

                // Reset input dalam form yang baru ditambahkan
                newForm.querySelectorAll("select, input").forEach((input) => {
                    input.value = "";

                    // Perbaiki atribut name agar mengikuti format array dengan index yang benar
                    if (input.name.includes("data[")) {
                        input.name = input.name.replace(/\d+/, shotIndex);
                    }
                });

                container.appendChild(newForm);
            }

            // Event listener untuk tombol tambah lokasi
            addButton.addEventListener("click", function() {
                addShotForm();
            });

            // Event listener untuk tombol hapus
            container.addEventListener("click", function(event) {
                if (event.target.classList.contains("delete-form")) {
                    const forms = document.querySelectorAll(".shot-form");

                    // Hapus form hanya jika jumlahnya lebih dari satu
                    if (forms.length > 1) {
                        event.target.closest(".shot-form").remove();
                    }
                }
            });
        });
    </script>




</x-layout>
