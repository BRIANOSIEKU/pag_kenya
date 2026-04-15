@extends('layouts.admin')

@section('content')
<div style="max-width:900px; margin:30px auto; background:#fff; padding:25px; border-radius:10px; box-shadow:0 3px 10px rgba(0,0,0,0.08);">

    <h1 style="margin-bottom:20px;">Edit Donation Instruction</h1>

    <hr style="margin-bottom:20px;">

    @if ($errors->any())
        <div style="background:#F44336; color:#fff; padding:10px; border-radius:6px; margin-bottom:15px;">
            <ul style="margin:0; padding-left:20px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.donations.update', $instruction->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="margin-bottom:15px;">
            <label><strong>Mode of Payment *</strong></label><br>
            <input type="text" name="mode_of_payment"
                   value="{{ old('mode_of_payment', $instruction->mode_of_payment) }}"
                   required
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Account Name *</strong></label><br>
            <input type="text" name="account_name"
                   value="{{ old('account_name', $instruction->account_name) }}"
                   required
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Account Number *</strong></label><br>
            <input type="text" name="account_number"
                   value="{{ old('account_number', $instruction->account_number) }}"
                   required
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">
        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Instruction / Details</strong></label><br>
            <textarea name="instruction" rows="4"
                      style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">{{ old('instruction', $instruction->instruction) }}</textarea>
        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Message / Urging Donors</strong></label><br>
            <textarea name="message" rows="4"
                      style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;">{{ old('message', $instruction->message) }}</textarea>
        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Upload New Image (Optional)</strong></label><br>
            <input type="file" name="image" id="image" accept="image/*" style="margin-top:8px;">
            <br>
            <small style="color:#666;">Allowed formats: JPG, JPEG, PNG (Max 2MB)</small>
        </div>

        @if($instruction->image)
            <div style="margin-bottom:15px;">
                <p><strong>Current Image:</strong></p>
                <img src="{{ asset('storage/' . $instruction->image) }}"
                     alt="Donation Image"
                     style="max-width:220px; border-radius:6px; border:1px solid #ddd; padding:5px;">
            </div>
        @endif

        <div style="margin-top:20px;">
            <button type="submit"
                    style="background:#2196F3; color:#fff; padding:10px 18px; border:none; border-radius:6px; cursor:pointer;">
                Update Instruction
            </button>

            <a href="{{ route('admin.donations.index') }}"
               style="margin-left:10px; color:#555; text-decoration:none;">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection