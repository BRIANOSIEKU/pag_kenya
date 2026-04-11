@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto px-10 py-10">

    <h2 class="text-3xl font-bold mb-8">Add New Leader for {{ $committee->name }}</h2>

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-5 rounded-lg mb-6">
            <ul class="list-disc pl-6 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-xl rounded-xl overflow-hidden">

        <form action="{{ route('admin.committees.leadership.store', $committee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <table class="w-full border border-gray-200">

                <!-- Full Name -->
                <tr class="border-b">
                    <td class="w-1/4 bg-gray-50 p-5 font-semibold text-lg">Full Name</td>
                    <td class="p-5">
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500" placeholder="Leader's full name">
                    </td>
                </tr>

                <!-- Position -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg">Position</td>
                    <td class="p-5">
                        <input type="text" name="position" value="{{ old('position') }}"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500" placeholder="Leader's role in this committee">
                    </td>
                </tr>

                <!-- Contact (Pivot Table) -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg">Contact</td>
                    <td class="p-5">
                        <input type="text" name="contact" value="{{ old('contact') }}"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500" placeholder="Committee-specific contact (phone/email)">
                    </td>
                </tr>

                <!-- Email -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg">Email Address</td>
                    <td class="p-5">
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500" placeholder="Leader's personal email (optional)">
                    </td>
                </tr>

                <!-- Brief Description -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg align-top">Brief Description</td>
                    <td class="p-5">
                        <textarea name="brief_description" rows="8"
                            class="w-full border rounded-lg px-4 py-4 text-lg focus:ring-2 focus:ring-blue-500 resize-none"
                            placeholder="Write a brief biography or description...">{{ old('brief_description') }}</textarea>
                    </td>
                </tr>

                <!-- Message -->
                <tr class="border-b">
                    <td class="bg-gray-50 p-5 font-semibold text-lg align-top">Message</td>
                    <td class="p-5">
                        <textarea name="message" rows="10"
                            class="w-full border rounded-lg px-4 py-4 text-lg focus:ring-2 focus:ring-blue-500 resize-none"
                            placeholder="Write a full message for this committee...">{{ old('message') }}</textarea>
                    </td>
                </tr>

                <!-- Photo -->
                <tr>
                    <td class="bg-gray-50 p-5 font-semibold text-lg align-top">Photo</td>
                    <td class="p-5">
                        <input type="file" name="photo" id="photoInput"
                            class="w-full border rounded-lg px-4 py-3 text-lg focus:ring-2 focus:ring-blue-500">

                        <div class="mt-6">
                            <img id="photoPreview" src="#" alt="Preview"
                                class="hidden w-64 h-64 object-cover rounded-lg shadow">
                        </div>
                    </td>
                </tr>

            </table>

            <div class="p-6">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-10 py-4 text-lg rounded-lg shadow">
                    Save Leader
                </button>
            </div>

        </form>
    </div>
</div>

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