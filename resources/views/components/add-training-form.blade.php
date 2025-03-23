<div id="shot-container">
    <div class="relative border rounded p-5 mb-2 font-bold italic shot-form">
        <!-- Tombol Delete di Pojok Kanan Atas -->
        <button type="button" class="absolute top-2 right-5 text-2xl text-red-500 hover:text-red-700 delete-form">
            X
        </button>

        <div class="mb-4">
            <label class="block text-sm mb-2 text-white" for="location_0">Location</label>
            <select name="data[0][location]" class="w-full bg-gray-700 text-white px-4 py-2 rounded location-select"
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
            </select>
        </div>

        <div class="mb-4 flex">
            <div class="w-1/2 mr-2">
                <label class="block text-sm mb-2 text-white" for="shotMade_0">Shot Made</label>
                <input name="data[0][shotmade]" class="w-full bg-gray-700 text-white px-4 py-2 rounded shot-made"
                    id="shotMade_0" type="number" min="0" />
            </div>
            <div class="w-1/2 ml-2">
                <label class="block text-sm mb-2 text-white" for="attempt_0">Attempt</label>
                <input name="data[0][attempt]" class="w-full bg-gray-700 text-white px-4 py-2 rounded attempt"
                    id="attempt_0" type="number" min="0" />
            </div>
        </div>
    </div>
</div>
