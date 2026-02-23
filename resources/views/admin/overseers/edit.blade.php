@extends('layouts.admin')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">Edit Church Overseer</h2>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
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

        <div class="card shadow-sm p-4">

            <!-- Full Name -->
            <div class="mb-3">
                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                <input type="text" 
                       name="name" 
                       class="form-control" 
                       placeholder="Enter full name"
                       value="{{ old('name', $overseer->name) }}" 
                       required>
            </div>

            <!-- District -->
            <div class="mb-3">
                <label class="form-label fw-bold">District Name <span class="text-danger">*</span></label>
                <input type="text" 
                       name="district_name" 
                       class="form-control" 
                       placeholder="Enter district name"
                       value="{{ old('district_name', $overseer->district_name) }}" 
                       required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label class="form-label fw-bold">Email Address</label>
                <input type="email" 
                       name="email" 
                       class="form-control" 
                       placeholder="Enter email (optional)"
                       value="{{ old('email', $overseer->email) }}">
            </div>

            <!-- Phone -->
            <div class="mb-3">
                <label class="form-label fw-bold">Phone Number</label>
                <input type="text" 
                       name="phone" 
                       class="form-control" 
                       placeholder="Enter phone number"
                       value="{{ old('phone', $overseer->phone) }}">
            </div>

            <!-- Gender -->
            <div class="mb-3">
                <label class="form-label fw-bold">Gender</label>
                <select name="gender" class="form-select">
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender', $overseer->gender) == 'Male' ? 'selected' : '' }}>
                        Male
                    </option>
                    <option value="Female" {{ old('gender', $overseer->gender) == 'Female' ? 'selected' : '' }}>
                        Female
                    </option>
                </select>
            </div>

            <!-- Photo -->
            <div class="mb-3">
                <label class="form-label fw-bold">Photo</label>

                @if($overseer->photo)
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$overseer->photo) }}" 
                             width="120" 
                             height="120"
                             class="rounded-circle shadow-sm"
                             style="object-fit:cover;">
                    </div>
                @endif

                <input type="file" name="photo" class="form-control">
                <small class="text-muted d-block mt-1">
                    Leave blank if you don’t want to change the photo.
                </small>
            </div>

            <!-- Form Actions -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.overseers.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-success">
                    Update Overseer
                </button>
            </div>

        </div>
    </form>
</div>

@endsection