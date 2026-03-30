@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Add HQ Staff Member</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.leadership.store', 'hq') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:10px;">
            <label>Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name') }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Position</label>
            <input type="text" name="position" value="{{ old('position') }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Contact</label>
            <input type="text" name="contact" value="{{ old('contact') }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Brief Description</label>
            <textarea name="brief_description" rows="3" style="width:100%; padding:8px;">{{ old('brief_description') }}</textarea>
        </div>

        <div style="margin-bottom:10px;">
            <label>Message</label>
            <textarea name="message" rows="3" style="width:100%; padding:8px;">{{ old('message') }}</textarea>
        </div>

        <div style="margin-bottom:10px;">
            <label>Photo</label>
            <input type="file" name="photo">
        </div>

        <button type="submit" style="background-color:#FF9800; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">
            Add HQ Staff
        </button>
    </form>
</div>
@endsection
