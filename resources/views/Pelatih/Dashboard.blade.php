<x-pelatih-layout>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
        <table class="w-full text-sm text-left rtl:text-right  text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 text-center uppercase bg-secondary border-secondary dark:bg-secondary dark:border-secondary dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        No
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User Image
                    </th>
                    <th scope="col" class="px-6 py-3">
                        User Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($players  as $index => $player)
                    <tr
                        class="bg-primary border-b text-center dark:bg-primary dark:border-secondary border-secondary hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="col" class="p-4">
                            {{ $index + 1 }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            <div class="flex justify-center items-center ">
                                    <img src="{{ asset('storage/' . $player->image) }}" alt="Profile Picture"
                                        class="w-20 h-20  rounded-full object-cover">
                                </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{ $player->name }}
                        </th>
                        <th scope="col" class="px-6 py-3 text-grafik">
                            {{ $player->role }}
                        </th>


                        <th class="px-6 py-4">
                            <a href="{{ route('pelatih.show', ['id' => $player->id]) }}" class="font-medium text-grafik dark:text-grafik hover:underline">
                                    View Detail
                                </a>
                        </th>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


</x-pelatih-layout>
