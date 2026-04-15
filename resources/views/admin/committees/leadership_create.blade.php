@extends('layouts.admin')

@section('content')

<div class="container" style="max-width:1100px; margin:auto; padding:30px;">

    <h2 style="font-size:28px; font-weight:bold; margin-bottom:25px;">
        Add New Leader for {{ $committee->name }}
    </h2>

    @if ($errors->any())
        <div style="background:#fdecea; color:#b71c1c; padding:15px; border-radius:8px; margin-bottom:20px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background:#fff; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.08); overflow:hidden;">

        <form action="{{ route('admin.committees.leadership.store', $committee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <table style="width:100%; border-collapse:collapse;">

                <!-- Full Name -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="width:25%; background:#f9f9f9; padding:15px; font-weight:bold;">
                        Full Name
                    </td>
                    <td style="padding:15px;">
                        <input type="text" name="full_name" value="{{ old('full_name') }}"
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;"
                            placeholder="Leader's full name">
                    </td>
                </tr>

                <!-- Position -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold;">
                        Position
                    </td>
                    <td style="padding:15px;">
                        <input type="text" name="position" value="{{ old('position') }}"
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;"
                            placeholder="Leader's role in this committee">
                    </td>
                </tr>

                <!-- Contact -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold;">
                        Contact
                    </td>
                    <td style="padding:15px;">
                        <input type="text" name="contact" value="{{ old('contact') }}"
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;"
                            placeholder="Phone or email">
                    </td>
                </tr>

                <!-- Email -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold;">
                        Email
                    </td>
                    <td style="padding:15px;">
                        <input type="email" name="email" value="{{ old('email') }}"
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;"
                            placeholder="Optional email address">
                    </td>
                </tr>

                <!-- Description -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold; vertical-align:top;">
                        Brief Description
                    </td>
                    <td style="padding:15px;">
                        <textarea name="brief_description" rows="6"
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; resize:none;"
                            placeholder="Short biography...">{{ old('brief_description') }}</textarea>
                    </td>
                </tr>

                <!-- Message -->
                <tr style="border-bottom:1px solid #eee;">
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold; vertical-align:top;">
                        Message
                    </td>
                    <td style="padding:15px;">
                        <textarea name="message" rows="8"
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; resize:none;"
                            placeholder="Full message...">{{ old('message') }}</textarea>
                    </td>
                </tr>

                <!-- Photo -->
                <tr>
                    <td style="background:#f9f9f9; padding:15px; font-weight:bold; vertical-align:top;">
                        Photo
                    </td>
                    <td style="padding:15px;">
                        <input type="file" name="photo" id="photoInput"
                            style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">

                        <div style="margin-top:15px;">
                            <img id="photoPreview" src="#" alt="Preview"
                                 style="display:none; width:200px; height:200px; object-fit:cover; border-radius:8px; box-shadow:0 2px 8px rgba(0,0,0,0.1);">
                        </div>
                    </td>
                </tr>

            </table>

            <div style="padding:20px;">
                <button type="submit"
                        style="background:#2196F3; color:#fff; padding:12px 25px; border:none; border-radius:6px; font-weight:bold; cursor:pointer;">
                    Save Leader
                </button>
            </div>

        </form>
    </div>
</div>

<script>
document.getElementById('photoInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('photoPreview');

    if (file) {
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
    }
});
</script>

@endsection