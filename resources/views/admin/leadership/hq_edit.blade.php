@extends('layouts.admin')

@section('content')
<div class="container">
    <h2>Edit HQ Staff Member</h2>

    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.leadership.update', ['hq', $leader->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom:10px;">
            <label>Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name', $leader->full_name) }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Position</label>
            <input type="text" name="position" value="{{ old('position', $leader->position) }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Contact</label>
            <input type="text" name="contact" value="{{ old('contact', $leader->contact) }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $leader->email) }}" style="width:100%; padding:8px;">
        </div>

        <div style="margin-bottom:10px;">
            <label>Brief Description</label>
            <textarea name="brief_description" rows="3" style="width:100%; padding:8px;">{{ old('brief_description', $leader->brief_description) }}</textarea>
        </div>

        <div style="margin-bottom:10px;">
            <label>Message</label>
            <textarea name="message" rows="3" style="width:100%; padding:8px;">{{ old('message', $leader->message) }}</textarea>
        </div>

        <div style="margin-bottom:10px;">
            <label>Current Photo</label><br>
            @if($leader->photo)
                <img src="{{ asset($leader->photo) }}" alt="{{ $leader->full_name }}" style="height:80px; border-radius:5px; margin-bottom:10px;">
            @endif
            <br>
            <label>Change Photo</label>
            <input type="file" name="photo">
        </div>

        <button type="submit" style="background-color:#FF9800; color:#fff; padding:10px 20px; border:none; border-radius:5px; cursor:pointer;">
            Update HQ Staff
        </button>
    </form>
</div>
@endsection
