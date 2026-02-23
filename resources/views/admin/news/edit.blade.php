@extends('layouts.admin')

@section('content')
<div style="max-width:800px; margin:auto;">

    <h1>Edit Church Overseer</h1>

    {{-- Flash Message --}}
    @if(session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation Errors --}}
    @if ($errors->any())
        <div style="color:red; margin-bottom:15px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.overseers.update', $overseer->id) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Full Name --}}
        <div style="margin-bottom:10px;">
            <label for="name"><strong>Full Name *</strong></label><br>
            <input type="text" id="name" name="name"
                   value="{{ old('name', $overseer->name) }}"
                   required
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        {{-- District --}}
        <div style="margin-bottom:10px;">
            <label for="district_name"><strong>District Name *</strong></label><br>
            <input type="text" id="district_name" name="district_name"
                   value="{{ old('district_name', $overseer->district_name) }}"
                   required
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        {{-- Email --}}
        <div style="margin-bottom:10px;">
            <label for="email"><strong>Email Address</strong></label><br>
            <input type="email" id="email" name="email"
                   value="{{ old('email', $overseer->email) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        {{-- Phone --}}
        <div style="margin-bottom:10px;">
            <label for="phone"><strong>Phone Number</strong></label><br>
            <input type="text" id="phone" name="phone"
                   value="{{ old('phone', $overseer->phone) }}"
                   style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
        </div>

        {{-- Gender --}}
        <div style="margin-bottom:10px;">
            <label for="gender"><strong>Gender</strong></label><br>
            <select id="gender" name="gender" 
                    style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
                <option value="">Select Gender</option>
                <option value="Male" {{ old('gender', $overseer->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender', $overseer->gender) == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        {{-- Photo --}}
        <div style="margin-bottom:15px;">
            <label for="photo"><strong>Photo</strong></label><br>

            @if($overseer->photo)
                <div style="margin-bottom:10px;">
                    <img src="{{ asset('storage/'.$overseer->photo) }}" 
                         alt="Overseer Photo" 
                         width="120" 
                         style="border:1px solid #ccc; padding:3px; border-radius:4px; display:block;">
                </div>
            @endif

            <input type="file" name="photo" id="photo">
            <p style="font-size:0.9em; color:#555;">Leave blank if you don’t want to change the photo.</p>
        </div>

        {{-- Form Actions --}}
        <div style="display:flex; justify-content:space-between; margin-top:20px;">
            <a href="{{ route('admin.overseers.index') }}" 
               style="padding:10px 20px; background:#6c757d; color:white; border-radius:4px; text-decoration:none;">
               Cancel
            </a>
            <button type="submit" 
                    style="padding:10px 20px; background:#007BFF; color:white; border:none; border-radius:4px; cursor:pointer;">
                Update Overseer
            </button>
        </div>

    </form>
</div>
@endsection