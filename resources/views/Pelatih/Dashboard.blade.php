<x-pelatih-layout>
    <h1 class="text-4xl font-bold italic text-whitemb-20 tracking-ligt">
        Welcome back, {{ auth()->user()->name }} <br>
        <span class="text-gray-500 whitespace-normal text-xl dark:text-gray-400">Welcome to dashboard</span>
    </h1>


    <h1 class="text-4xl font-bold italic text-white mb-5">Dashboard <span class="text-grafik">Player Training Progress</span></h1>
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
        <table class="w-full text-sm text-left rtl:text-right  text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 uppercase bg-primary border-secondary dark:bg-primary dark:border-secondary dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        Id
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Player name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Total Training
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainingCounts as $training)
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="col" class="p-4">
                            {{ $training->id }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ $training->user->name }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ $training->training_count }}
                        </th>

                        <td class="flex items-center px-6 py-4">
                            @foreach ($overallShot as $shot)
                                <a href="{{ route('pelatih.show', ['id' => $shot->id]) }}"
                                    class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View Detail</a>
                            @endforeach
                            <a href="#" class="font-medium text-red-600 dark:text-red-500 hover:underline ms-3">Remove</a>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</x-pelatih-layout>
