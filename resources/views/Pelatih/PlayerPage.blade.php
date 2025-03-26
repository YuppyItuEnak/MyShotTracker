<x-pelatih-layout>



    <div class="relative overflow-x-auto shadow-md sm:rounded-lg ">
        <table class="w-full text-sm text-left rtl:text-right  text-gray-500 dark:text-gray-400">
            <thead
                class="text-xs text-gray-700 text-center uppercase bg-primary border-secondary dark:bg-primary dark:border-secondary dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        Id
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
                </tr>
            </thead>
            <tbody>

                @foreach ($user as $us)
                    @if ($us->role == 'Pemain')
                        <tr
                            class="bg-white border-b text-center dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th scope="col" class="p-4">
                                {{ $us->id }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <div class="flex justify-center items-center ">
                                    <img src="{{ asset('storage/' . $us->image) }}" alt="Profile Picture"
                                        class="w-20 h-20  rounded-full object-cover">
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ $us->name }}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{ $us->role }}
                            </th>

                        </tr>
                    @else
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>


</x-pelatih-layout>
