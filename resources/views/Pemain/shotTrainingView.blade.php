<x-layout>

    <!-- SECTION DESKTOP -->
    <div class="hidden md:flex items-center justify-between">
        <h1 class="text-4xl font-extrabold text-white tracking-tight md:text-5xl lg:text-6xl">
            Shot Training
        </h1>
        <div>
            <a href="#"
                class="block max-w-sm p-6 bg-primary border border-gray-200 rounded-lg shadow-sm">

                <!-- Header Card -->
                <div class="flex items-center justify-between">
                    <div>
                        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                            Shot Progress
                        </h5>
                        <p class="font-normal text-gray-700 dark:text-gray-400">
                            Shot progress in a week
                        </p>
                    </div>

                    <button type="button"
                        class="text-black ml-5 bg-grafik focus:ring-4 focus:outline-none
                     font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                        See Detail
                        <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                    </button>
                </div>
            </a>
        </div>
    </div>

    <!-- SECTION MOBILE -->
    <div class="flex md:hidden flex-col items-center text-center p-6 space-y-4">
        <h1 class="text-3xl text-white font-extrabold tracking-tight ">
            Shot Training
        </h1>
        <a href="#"
            class="block w-full p-6 bg-primary border border-gray-200 rounded-lg shadow-sm">

            <div class="flex flex-col items-center">
                <h5 class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                    Shot Progress
                </h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                    Shot progress in a week
                </p>
            </div>

            <button type="button"
                class="mt-4 w-full text-black bg-grafik hover:bg-blue-800 focus:ring-4 focus:outline-none
             font-medium rounded-lg text-sm px-5 py-2.5 flex items-center justify-center gap-x-2">
                See Detail
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 5h12m0 0L9 1m4 4L9 9" />
                </svg>
            </button>

        </a>
    </div>




    <h1 class="mb-4 text-2xl font-extrabold leading-none tracking-tight text-white md:text-4xl lg:text-4xl">My
        History
    </h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 justify-center place-items-center">
        <x-shot-training-card></x-shot-training-card>
        <x-shot-training-card></x-shot-training-card>
        <x-shot-training-card></x-shot-training-card>
    </div>
</x-layout>
