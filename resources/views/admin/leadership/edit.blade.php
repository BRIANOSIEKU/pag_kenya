@extends('layouts.admin')

@section('content')
<div class="max-w-3xl mx-auto mt-10 bg-white p-8 rounded-xl shadow-lg">
    <h1 class="text-2xl font-bold text-center mb-6">Edit Leader</h1>

    <form action="{{ route('admin.leadership.update', [$type, $leader->id]) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Full Name -->
        <div>
            <label class="block font-semibold mb-1">Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name', $leader->full_name) }}" placeholder="Full Name" required
                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Position -->
        <div>
            <label class="block font-semibold mb-1">Position</label>
            <input type="text" name="position" value="{{ old('position', $leader->position) }}" placeholder="Position" required
                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">
        </div>

        <!-- Contact & Email -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block font-semibold mb-1">Contact</label>
                <input type="text" name="contact" value="{{ old('contact', $leader->contact) }}" placeholder="Contact" required
                    class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block font-semibold mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $leader->email) }}" placeholder="Email" required
                    class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">
            </div>
        </div>

        <!-- Brief Description -->
        <div>
            <label class="block font-semibold mb-1">Brief Description</label>
            <textarea name="brief_description" rows="4" placeholder="Short description about the leader"
                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400" required>{{ old('brief_description', $leader->brief_description) }}</textarea>
        </div>

        <!-- Message -->
        <div>
            <label class="block font-semibold mb-1">Message (Optional)</label>
            <textarea name="message" rows="4" placeholder="Message" 
                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400">{{ old('message', $leader->message) }}</textarea>
        </div>

        <!-- Photo Upload & Preview -->
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div>
                <label class="block font-semibold mb-1">Upload Photo</label>
                <input type="file" name="photo" accept="image/*" onchange="previewImage(event)"
                    class="border p-2 rounded-lg cursor-pointer">
            </div>
            <div>
                <img id="photoPreview" src="{{ $leader->photo ? asset($leader->photo) : 'https://via.placeholder.com/150' }}"
                    class="w-40 h-40 object-cover rounded-xl shadow-md border">
            </div>
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button type="submit" 
                class="bg-blue-600 text-white font-semibold px-8 py-3 rounded-lg shadow hover:bg-blue-700 transition">
                Update Leader
            </button>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById('photoPreview').src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
