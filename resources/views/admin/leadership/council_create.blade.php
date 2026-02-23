@extends('layouts.admin')

@section('content')

<!-- Back to Dashboard -->
<a href="{{ route('admin.dashboard') }}" style="padding:8px 12px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:15px; display:inline-block;">
    &larr; Back to Dashboard
</a>
<div class="container">
    <h2 class="mb-4">Add Church Council Member</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.leadership.store', 'council') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:15px;">
            <label for="full_name">Full Name *</label>
            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name') }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="position">Position *</label>
            <input type="text" name="position" id="position" class="form-control" value="{{ old('position') }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="contact">Contact *</label>
            <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact') }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="brief_description">Brief Description</label>
            <textarea name="brief_description" id="brief_description" class="form-control">{{ old('brief_description') }}</textarea>
        </div>

        <div style="margin-bottom:15px;">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control">{{ old('message') }}</textarea>
        </div>

        <div style="margin-bottom:15px;">
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo" class="form-control">
        </div>

        <button type="submit" style="background-color:#2196F3; color:#fff; padding:10px 20px; border:none; border-radius:5px;">Add Member</button>
        <a href="{{ route('admin.leadership.index', 'council') }}" style="margin-left:10px; color:#555;">Cancel</a>
    </form>
</div>
@endsection
