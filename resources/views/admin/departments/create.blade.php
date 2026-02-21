@extends('layouts.admin')

@section('content')
<h1>Create Department</h1>

<a href="{{ route('admin.departments.index') }}" 
   style="padding:8px 14px; background:#9C27B0; color:#fff; border-radius:6px; text-decoration:none; margin-bottom:20px; display:inline-block;">
   ← Back to Departments
</a>

@if ($errors->any())
<div style="margin-bottom:15px; padding:10px; background:#F44336; color:#fff; border-radius:6px;">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('admin.departments.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Name -->
    <div style="margin-bottom:12px;">
        <label for="name"><strong>Name</strong></label><br>
        <input type="text" name="name" id="name" value="{{ old('name') }}" required
               style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">
    </div>

    <!-- Leadership -->
    <div style="margin-bottom:12px;">
        <label for="leadership"><strong>Leadership</strong></label><br>
        <textarea name="leadership" id="leadership" rows="3"
                  style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">{{ old('leadership') }}</textarea>
    </div>

    <!-- Overview -->
    <div style="margin-bottom:12px;">
        <label for="overview"><strong>Overview</strong></label><br>
        <textarea name="overview" id="overview" rows="3"
                  style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">{{ old('overview') }}</textarea>
    </div>

    <!-- Activities -->
    <div style="margin-bottom:12px;">
        <label for="activities"><strong>Activities</strong></label><br>
        <textarea name="activities" id="activities" rows="3"
                  style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">{{ old('activities') }}</textarea>
    </div>

    <!-- Description -->
    <div style="margin-bottom:12px;">
        <label for="description"><strong>Description</strong></label><br>
        <textarea name="description" id="description" rows="3"
                  style="width:100%; padding:8px; border-radius:6px; border:1px solid #ccc;">{{ old('description') }}</textarea>
    </div>

    <!-- Downloads -->
    <div style="margin-bottom:12px;">
        <label for="downloads"><strong>Downloadable Document</strong></label><br>
        <input type="file" name="downloads" id="downloads"
               accept=".pdf,.doc,.docx"
               style="width:100%; padding:6px;">
    </div>

    <!-- Photo -->
    <div style="margin-bottom:12px;">
        <label for="photo"><strong>Photo</strong></label><br>
        <input type="file" name="photo" id="photo"
               accept="image/*"
               style="width:100%; padding:6px;">
    </div>

    <button type="submit" 
            style="padding:10px 16px; background:#4CAF50; color:#fff; border-radius:6px; border:none; cursor:pointer;">
        Create Department
    </button>
</form>
@endsection
