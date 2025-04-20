<x-layout>
    {{--

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
        </div>



        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-6">
            @foreach ($overallShot as $overallShot)
                <x-shot-training-card :overallShot="$overallShot"></x-shot-training-card>
            @endforeach
        </div>
    </div>
 --}}



    <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Location
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Shot Made
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Attempt
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainingSession as $item)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <td class="px-6 py-4">
                            {{ $item->location }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->attempt }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->shotmade }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="w-full mt-4 mb-4">
            <form action="{{ route('training.updateData') }}" method="POST">
                @csrf
                <button type="submit" id="submit-button" class="bg-gray-500 text-white font-bold italic px-4 py-2 rounded w-full">
                    Submit All
                </button>
            </form>
        </div>

    </div>




</x-layout>
