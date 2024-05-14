<x-filament-panels::page>
    @php
        $districts = App\Models\District::with('subDistricts')->get();
    @endphp
<div class="bg-white rounded-lg w-1/2 px-4 py-4">
    <form action="{{ route('report') }}" method="POST" class="px-4">
        @csrf
        <div class="flex justify-between py-5 items-center">
    <label for="district">District:</label>
    <select id="district" name="district" class="rounded-lg">
        <option value="">Select District</option>
        @foreach ($districts as $district)
            <option value="{{ $district->id }}">{{ $district->e_name }}</option>
        @endforeach
    </select>
</div>
<div class="flex justify-between  items-center py-5">
    <label for="subdistrict">Subdistrict:</label>
    <select id="subdistrict" name="subdistrict" class="rounded-lg">
        <option value="">Select Upazila</option>
    </select>
</div>
<div class="flex justify-between  items-center py-5">
    {{-- <label for="subdistrict">Report Type:</label>
    <select  name="type" class="rounded-lg">
        <option value="1">Members Report</option>
        <option value="2">Disbursment Report</option>
        <option value="3">Subscription Payment Report</option>
        <option value="4">Select Subdistrict</option>
    </select> --}}
     <input type="hidden" value="1" name="reporttype">
</div>
<div class="flex justify-end">
<button class="fi-btn relative grid-flow-col items-center justify-center font-semibold outline-none transition duration-75 focus-visible:ring-2 rounded-lg fi-color-custom fi-btn-color-primary fi-size-md fi-btn-size-md gap-1.5 px-3 py-2 text-sm inline-grid shadow-sm bg-blue-500 text-white hover:bg-custom-500 dark:bg-custom-500 dark:hover:bg-custom-400 focus-visible:ring-custom-500/50 dark:focus-visible:ring-custom-400/50 fi-ac-btn-action" style="background-color: #2563eb">Submit</button></div>
</form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get references to the district and subdistrict select elements
        var districtSelect = document.getElementById('district');
        var subdistrictSelect = document.getElementById('subdistrict');

        // Add an event listener to the district select element
        districtSelect.addEventListener('change', function () {
            // Clear existing subdistrict options
            subdistrictSelect.innerHTML = '<option value="">Select Upazila</option>';

            // Get the selected district ID
            var selectedDistrictId = districtSelect.value;

            // If a district is selected, fetch and populate subdistrict options
            if (selectedDistrictId) {
                // Replace the URL with your actual route to fetch subdistricts
                var url = '/get-subdistricts/' + selectedDistrictId;

                // Fetch subdistricts using AJAX
                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        // Populate subdistrict options
                        data.forEach(subdistrict => {
                            var option = document.createElement('option');
                            option.value = subdistrict.id;
                            option.text = subdistrict.e_name;
                            subdistrictSelect.add(option);
                        });
                    })
                    .catch(error => console.error('Error:', error));
            }
        });
    });
</script>

</x-filament-panels::page>
