<x-layout>


    <!-- SECTION DESKTOP -->
    <div class="container mx-auto px-4 py-6">
        <div class="flex items-center justify-between">
            <h1 class="text-4xl font-extrabold text-white tracking-tight md:text-5xl lg:text-6xl">
                Welcome to <br> <span class="text-grafik">MyShotTracker</span>
            </h1>
        </div>

        <!-- My History Section -->
        <div class="flex flex-col md:flex-row items-center justify-between mt-8 mb-6 gap-4">
            <!-- Title -->
            <h1 class="text-2xl md:text-4xl font-extrabold tracking-tight text-white">
                My History
            </h1>

            <!-- Filter Section -->
            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4">
                <h1 class="text-white text-sm md:text-2xl tracking-tight font-bold">
                    Filter by Date:
                </h1>


                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                        </svg>
                    </div>
                    <input id="datepicker-autohide" datepicker datepicker-autohide type="text"
                        class="bg-black border border-gray-300 text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                        placeholder="Select date">
                </div>



            </div>
        </div>



        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($overallShot as $overallShot)
                <x-shot-training-card :overallShot="$overallShot"></x-shot-training-card>
            @endforeach
        </div>
    </div>


</x-layout>
