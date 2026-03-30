@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">

    <h2 class="text-2xl font-bold mb-6">Add New {{ ucfirst($type) }} Leader</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('admin.leadership.store', $type) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Full Name -->
                <div>
                    <label class="block font-semibold mb-2">Full Name</label>
                    <input type="text" name="full_name" value="{{ old('full_name') }}" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Position -->
                <div>
                    <label class="block font-semibold mb-2">Position</label>
                    <input type="text" name="position" value="{{ old('position') }}" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Contact -->
                <div>
                    <label class="block font-semibold mb-2">Contact</label>
                    <input type="text" name="contact" value="{{ old('contact') }}" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Email -->
                <div>
                    <label class="block font-semibold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Brief Description -->
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-2">Brief Description</label>
                    <textarea name="brief_description" rows="4" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('brief_description') }}</textarea>
                </div>

                <!-- Message (Optional) -->
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-2">Message (Optional)</label>
                    <textarea name="message" rows="4" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('message') }}</textarea>
                </div>

                <!-- Photo Upload -->
                <div class="md:col-span-2">
                    <label class="block font-semibold mb-2">Photo</label>
                    <input type="file" name="photo" id="photoInput" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <div class="mt-4">
                        <img id="photoPreview" src="#" alt="Preview" class="hidden w-48 h-48 object-cover rounded shadow">
                    </div>
                </div>

            </div>

            <button type="submit" 
                class="mt-6 bg-blue-600 hover:bg-blue-700 text-white font-bold px-6 py-3 rounded shadow transition duration-200">
                Save Leader
            </button>
        </form>
    </div>
</div>

<!-- Photo Preview Script -->
<script>
document.getElementById('photoInput').addEventListener('change', function(event) {
    const [file] = event.target.files;
    const preview = document.getElementById('photoPreview');
    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('hidden');
    }
});
</script>

@endsection
