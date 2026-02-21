@extends('layouts.admin')

@section('content')
<h1>Edit Donation Instruction</h1>
<hr>

@if ($errors->any())
    <div style="color:red; margin-bottom:15px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('admin.donations.update', $instruction->id) }}" 
      method="POST" 
      enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div style="margin-bottom:15px;">
        <label for="mode_of_payment">Mode of Payment *</label><br>
        <input type="text" 
               name="mode_of_payment" 
               id="mode_of_payment" 
               value="{{ old('mode_of_payment', $instruction->mode_of_payment) }}" 
               required
               style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="account_name">Account Name *</label><br>
        <input type="text" 
               name="account_name" 
               id="account_name" 
               value="{{ old('account_name', $instruction->account_name) }}" 
               required
               style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="account_number">Account Number *</label><br>
        <input type="text" 
               name="account_number" 
               id="account_number" 
               value="{{ old('account_number', $instruction->account_number) }}" 
               required
               style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="instruction">Instruction / Details</label><br>
        <textarea name="instruction" 
                  id="instruction" 
                  rows="3" 
                  style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">{{ old('instruction', $instruction->instruction) }}</textarea>
    </div>

    <div style="margin-bottom:15px;">
        <label for="message">Message / Urging Donors</label><br>
        <textarea name="message" 
                  id="message" 
                  rows="3" 
                  style="width:100%; padding:8px; border:1px solid #ccc; border-radius:4px;">{{ old('message', $instruction->message) }}</textarea>
    </div>

    <!-- ✅ IMAGE SECTION -->
    <div style="margin-bottom:15px;">
        <label for="image">Upload New Image (Optional)</label><br>
        <input type="file" 
               name="image" 
               id="image" 
               accept="image/*"
               style="margin-top:5px;">
        <small style="color:#666;">
            Allowed: JPG, JPEG, PNG (Max 2MB)
        </small>
    </div>

    @if($instruction->image)
        <div style="margin-bottom:15px;">
            <p style="margin-bottom:5px;"><strong>Current Image:</strong></p>
            <img src="{{ asset('storage/' . $instruction->image) }}" 
                 alt="Donation Image" 
                 style="max-width:200px; border:1px solid #ddd; padding:5px; border-radius:6px;">
        </div>
    @endif

    <button type="submit" 
            style="background-color:#2196F3; color:#fff; padding:10px 15px; border:none; border-radius:6px; cursor:pointer;">
        Update Instruction
    </button>

    <a href="{{ route('admin.donations.index') }}" 
       style="margin-left:10px; color:#555;">
        Cancel
    </a>
</form>
@endsection
