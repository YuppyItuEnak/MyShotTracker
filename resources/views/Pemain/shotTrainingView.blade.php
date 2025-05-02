<x-layout>
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
                    <th scope="col" class="px-6 py-3">
                        Duration
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
                            {{ $item->shotmade }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->attempt }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $item->duration }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="w-full mt-4 mb-4">
            <form action="{{ route('training.updateData') }}" method="POST">
                @csrf
                <button type="submit" id="submit-button"
                    class="bg-gray-500 text-white font-bold italic px-4 py-2 rounded w-full">
                    Submit All
                </button>
            </form>
        </div>
    </div>
</x-layout>
