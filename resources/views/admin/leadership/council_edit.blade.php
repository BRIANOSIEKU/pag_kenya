@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Church Council Member</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.leadership.update', ['council', $leader->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label for="full_name">Full Name *</label>
            <input type="text" name="full_name" id="full_name" class="form-control" value="{{ old('full_name', $leader->full_name) }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="position">Position *</label>
            <input type="text" name="position" id="position" class="form-control" value="{{ old('position', $leader->position) }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="contact">Contact *</label>
            <input type="text" name="contact" id="contact" class="form-control" value="{{ old('contact', $leader->contact) }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $leader->email) }}" required>
        </div>

        <div style="margin-bottom:15px;">
            <label for="brief_description">Brief Description</label>
            <textarea name="brief_description" id="brief_description" class="form-control">{{ old('brief_description', $leader->brief_description) }}</textarea>
        </div>

        <div style="margin-bottom:15px;">
            <label for="message">Message</label>
            <textarea name="message" id="message" class="form-control">{{ old('message', $leader->message) }}</textarea>
        </div>

        <div style="margin-bottom:15px;">
            <label for="photo">Photo</label>
            <input type="file" name="photo" id="photo" class="form-control">
            @if($leader->photo)
                <p style="margin-top:5px;">Current Photo:</p>
                <img src="{{ asset($leader->photo) }}" alt="{{ $leader->full_name }}" style="height:120px; border-radius:5px;">
            @endif
        </div>

        <button type="submit" style="background-color:#4CAF50; color:#fff; padding:10px 20px; border:none; border-radius:5px;">Update Member</button>
        <a href="{{ route('admin.leadership.index', 'council') }}" style="margin-left:10px; color:#555;">Cancel</a>
    </form>
</div>
@endsection
