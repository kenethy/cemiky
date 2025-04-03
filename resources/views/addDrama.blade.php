@extends('layout')

@section('content')
    {{-- Main container with a slightly softer black background --}}
    <div class="mt-[100px] min-h-screen bg-gray-950 text-neutral-200 w-full p-6 md:p-8 flex items-center justify-center">

        {{-- Form container: centered, max-width, darker background, rounded corners, shadow --}}
        <div class="w-full max-w-3xl bg-neutral-900 rounded-xl shadow-2xl p-8">

            <h1 class="text-3xl font-bold mb-8 text-center text-white">Add New Drama</h1>

            <form id="promotionForm">
                @csrf

                {{-- Title Input --}}
                <div class="mb-6">
                    <label for="title" class="block font-semibold mb-2 text-neutral-300">Title</label>
                    <input type="text" name="title" id="title"
                           class="w-full bg-neutral-800 rounded-md p-3 mt-1 text-white border border-neutral-700 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
                           value="{{ old('title') }}" required placeholder="Enter drama title...">
                </div>

                {{-- Description Input --}}
                <div class="mb-6">
                    <label for="description" class="block font-semibold mb-2 text-neutral-300">Description</label>
                    <textarea name="description" id="description" rows="5"
                              class="w-full bg-neutral-800 rounded-md p-3 mt-1 text-white border border-neutral-700 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 focus:outline-none transition duration-200 ease-in-out"
                              required placeholder="Describe the drama...">{{ old('description') }}</textarea>
                </div>

                {{-- Image Upload --}}
                <div class="mb-6">
                    <label for="image" class="block font-semibold mb-2 text-neutral-300">
                        Images <span class="text-sm text-neutral-500">(Upload 1 Portrait + 1 Landscape)</span>
                    </label>
                    <label for="image"
                           class="flex flex-col items-center justify-center w-full px-4 py-10 mt-1 bg-neutral-800 text-neutral-400 rounded-lg shadow-md tracking-wide uppercase border-2 border-dashed border-neutral-700 cursor-pointer hover:bg-neutral-700 hover:border-orange-500 hover:text-orange-400 transition duration-200 ease-in-out">
                        <svg class="w-10 h-10 text-neutral-500" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5V18a2.25 2.25 0 002.25 2.25h13.5A2.25 2.25 0 0021 18v-1.5M16.5 12L12 16.5m0 0L7.5 12M12 16.5V3"></path>
                        </svg>
                        <span class="mt-3 text-base leading-normal">Select Images</span>
                        <input id="image" type="file" name="image[]" accept="image/*" multiple class="hidden">
                    </label>
                    {{-- Image Preview Container --}}
                    <div id="previewContainer" class="grid grid-cols-2 gap-4 mt-4">
                        {{-- Previews will be rendered here by JavaScript --}}
                    </div>
                </div>

                {{-- Genres Checkboxes --}}
                <div class="mb-8">
                    <label class="block font-semibold mb-3 text-neutral-300">Genres</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                        @foreach ($genres as $genre)
                            <label class="flex items-center space-x-3 p-3 rounded-md cursor-pointer hover:bg-neutral-800 transition duration-150 ease-in-out">
                                <input type="checkbox" name="genre[]" value="{{ $genre['id'] }}"
                                       class="form-checkbox h-5 w-5 text-orange-500 bg-neutral-700 border-neutral-600 rounded focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-neutral-900 transition duration-150 ease-in-out">
                                <span class="text-neutral-300 text-sm select-none">{{ $genre['name'] }}</span>
                            </label>
                        @endforeach
                    </div>
                    <p class="text-sm text-neutral-500 mt-3">* Choose one or more relevant genres.</p>
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full px-8 py-3 bg-orange-600 hover:bg-orange-700 rounded-md text-white font-bold focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 focus:ring-offset-neutral-900 transition duration-200 ease-in-out">
                    Submit Drama
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const input = document.getElementById('image');
        const previewContainer = document.getElementById('previewContainer');
        let fileArray = []; // Stores the current files

        input.addEventListener('change', function() {
            const newFiles = Array.from(input.files);
            // Attempt to add new files to the existing ones
            const potentialFiles = [...fileArray, ...newFiles];

            // Limit to 2 files total
            if (potentialFiles.length > 2) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Maximum Images Reached',
                    text: 'Please upload only 2 images: 1 portrait and 1 landscape.',
                    confirmButtonColor: '#f97316', // Orange
                    background: '#1f2937', // Dark background for SweetAlert
                    color: '#e5e7eb'       // Light text color for SweetAlert
                });
                // Reset the input visually, but keep the existing valid files in fileArray
                input.value = '';
                return;
            }

            // Update fileArray with the allowed files
            fileArray = potentialFiles;
            renderPreviews();
            updateFileInput(); // Important: Sync the input.files with fileArray
        });

        function renderPreviews() {
            previewContainer.innerHTML = ''; // Clear existing previews
            fileArray.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewWrapper = document.createElement('div');
                    previewWrapper.className = 'relative rounded-lg overflow-hidden shadow-md group'; // Added group for hover effect on remove button

                    // Image Tag
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-48 object-cover'; // Maintain aspect ratio covering the area

                    // Image Label (Top Left)
                    const label = document.createElement('span');
                    label.className = 'absolute top-2 left-2 bg-orange-600 bg-opacity-80 text-white text-xs font-bold px-2 py-1 rounded z-10';
                    label.textContent = index === 0 ? 'Portrait' : 'Landscape'; // Suggest role

                    // Remove Button (Top Right)
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.className = 'absolute top-2 right-2 text-white bg-red-600 hover:bg-red-700 rounded-full w-6 h-6 flex items-center justify-center text-xs z-10 opacity-70 group-hover:opacity-100 transition-opacity duration-150';
                    removeBtn.innerHTML = '✕'; // Use a simple cross
                    removeBtn.onclick = () => removeImage(index);

                    previewWrapper.appendChild(label);
                    previewWrapper.appendChild(removeBtn);
                    previewWrapper.appendChild(img);
                    previewContainer.appendChild(previewWrapper);
                };
                reader.readAsDataURL(file);
            });
        }

        function updateFileInput() {
            // Create a new FileList and assign it to the input
            const dataTransfer = new DataTransfer();
            fileArray.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;
        }

        function removeImage(index) {
            fileArray.splice(index, 1); // Remove file from array
            renderPreviews(); // Re-render previews
            updateFileInput(); // Update the actual input element's files
        }

        const form = document.getElementById('promotionForm');

        form.addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // --- Basic Validation ---
            const title = document.getElementById('title').value.trim();
            const description = document.getElementById('description').value.trim();
            const genreChecked = document.querySelectorAll('input[name="genre[]"]:checked').length;
            const currentFiles = Array.from(input.files); // Use the actual input.files for submission check

            let validationMessage = '';
            if (!title) validationMessage += 'Title cannot be empty.<br>';
            if (!description) validationMessage += 'Description cannot be empty.<br>';
            if (genreChecked === 0) validationMessage += 'At least one genre must be selected.<br>';
            if (currentFiles.length !== 2) validationMessage += 'Exactly 2 images (1 portrait, 1 landscape) are required.';

            if (validationMessage) {
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Failed',
                    html: validationMessage, // Use html for line breaks
                    background: '#1f2937',
                    color: '#e5e7eb',
                    confirmButtonColor: '#f97316'
                });
                return; // Stop submission
            }

            // --- Image Orientation Validation ---
            if (currentFiles.length === 2) {
                validateImageOrientations(currentFiles).then(isValid => {
                    if (isValid) {
                        submitFormData(); // Proceed if orientations are correct
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid Image Orientations',
                            html: 'The first image must be <b>portrait</b> (height > width),<br>the second image must be <b>landscape</b> (width > height).<br>Please re-upload or reorder.',
                            confirmButtonColor: '#f97316',
                            background: '#1f2937',
                            color: '#e5e7eb'
                        });
                    }
                });
            } else {
                 // This case should technically be caught by the basic validation above, but as a fallback:
                 submitFormData(); // Or handle error if needed
            }
        });

        // Helper function to check image orientations
        function validateImageOrientations(files) {
            return new Promise((resolve) => {
                const reader1 = new FileReader();
                const reader2 = new FileReader();
                let isPortrait = false;
                let isLandscape = false;

                reader1.onload = function(e1) {
                    const img1 = new Image();
                    img1.onload = function() {
                        isPortrait = img1.height > img1.width; // Check if first is portrait

                        reader2.onload = function(e2) {
                            const img2 = new Image();
                            img2.onload = function() {
                                isLandscape = img2.width > img2.height; // Check if second is landscape
                                resolve(isPortrait && isLandscape); // Resolve promise with validation result
                            };
                            img2.src = e2.target.result;
                        };
                        reader2.readAsDataURL(files[1]);
                    };
                    img1.src = e1.target.result;
                };
                reader1.readAsDataURL(files[0]);
            });
        }

        // Function to handle the actual form submission via Fetch
        function submitFormData() {
            const formData = new FormData(form); // Creates FormData from the form element
             // Clear existing images and add from fileArray to ensure correct order/files if needed (optional, FormData(form) usually works)
             // formData.delete('image[]');
             // fileArray.forEach(f => formData.append('image[]', f));

            // Get genres separately as checkbox values might not be optimal in FormData directly
            const selectedGenres = Array.from(document.querySelectorAll('input[name="genre[]"]:checked')).map(cb => cb.value);
            formData.append('genres', JSON.stringify(selectedGenres)); // Send genres as a JSON string

            // Add CSRF token manually if not included by default setup
            // formData.append('_token', '{{ csrf_token() }}');

             Swal.fire({ // Optional: Show loading indicator
                title: 'Submitting...',
                text: 'Please wait while the drama is being added.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
                background: '#1f2937',
                color: '#e5e7eb'
            });

            fetch("{{ route('drama.add.save') }}", {
                method: "POST",
                headers: {
                    // 'Content-Type': 'multipart/form-data', // Not needed for Fetch with FormData
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Crucial for Laravel security
                    'Accept': 'application/json' // Expect JSON response
                },
                body: formData
            })
            .then(async response => {
                const data = await response.json(); // Always try to parse JSON
                if (!response.ok) {
                    // Throw an error with the message from the server if available
                    throw new Error(data.message || `Server responded with status: ${response.status}`);
                }
                return data; // Return the parsed JSON data
            })
            .then(data => {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: data.message || 'Drama added successfully.', // Use server message if provided
                    confirmButtonColor: '#f97316',
                    background: '#1f2937',
                    color: '#e5e7eb'
                }).then(() => {
                    // Redirect after success
                    window.location.href = "{{ route('homepage') }}";
                });
            })
            .catch(error => {
                console.error('Submission Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Oops! Something went wrong.',
                    text: error.message || 'Failed to submit data. Please try again.',
                    confirmButtonColor: '#f97316',
                    background: '#1f2937',
                    color: '#e5e7eb'
                });
            });
        }

    </script>
@endsection