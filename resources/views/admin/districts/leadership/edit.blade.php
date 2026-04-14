@extends('layouts.admin')

@section('content')

<h2>Edit Leader</h2>

<form method="POST"
      action="{{ route('admin.districts.leadership.update', [$district->id, $leader->id]) }}"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <!-- NAME -->
    <label>Name</label><br>
    <input type="text"
           name="name"
           value="{{ old('name', $leader->name) }}"
           required><br><br>

    <!-- POSITION -->
    <label>Position</label><br>
    <select name="position" required>
        <option value="">-- Select Position --</option>

        <option value="Overseer"
            {{ old('position', $leader->position) == 'Overseer' ? 'selected' : '' }}>
            Overseer
        </option>

        <option value="Secretary"
            {{ old('position', $leader->position) == 'Secretary' ? 'selected' : '' }}>
            Secretary
        </option>

        <option value="CEYD"
            {{ old('position', $leader->position) == 'CEYD' ? 'selected' : '' }}>
            CEYD
        </option>

        <option value="Women Director"
            {{ old('position', $leader->position) == 'Women Director' ? 'selected' : '' }}>
            Women Director
        </option>

        <option value="LayPerson"
            {{ old('position', $leader->position) == 'LayPerson' ? 'selected' : '' }}>
            LayPerson
        </option>

        <option value="Treasurer"
            {{ old('position', $leader->position) == 'Treasurer' ? 'selected' : '' }}>
            Treasurer
        </option>

        <option value="Senior Pastor"
            {{ old('position', $leader->position) == 'Senior Pastor' ? 'selected' : '' }}>
            Senior Pastor
        </option>

    </select><br><br>

    <!-- GENDER -->
    <label>Gender</label><br>
    <select name="gender" required>
        <option value="Male"
            {{ old('gender', $leader->gender) == 'Male' ? 'selected' : '' }}>
            Male
        </option>

        <option value="Female"
            {{ old('gender', $leader->gender) == 'Female' ? 'selected' : '' }}>
            Female
        </option>
    </select><br><br>

    <!-- CONTACT -->
    <label>Contact</label><br>
    <input type="text"
           name="contact"
           value="{{ old('contact', $leader->contact) }}"><br><br>

    <!-- NATIONAL ID -->
    <label>National ID</label><br>
    <input type="text"
           name="national_id"
           value="{{ old('national_id', $leader->national_id) }}"><br><br>

    <!-- DATE OF BIRTH -->
    <label>Date of Birth</label><br>
    <input type="date"
           name="dob"
           value="{{ old('dob', \Carbon\Carbon::parse($leader->dob)->format('Y-m-d')) }}"><br><br>

    {{-- ================= BANK DETAILS ================= --}}
    <h3>Bank Details</h3>

    <label>Bank Name</label><br>
    <input type="text"
           name="bank_name"
           value="{{ old('bank_name', $leader->bank_name) }}"
           required><br><br>

    <label>Branch</label><br>
    <input type="text"
           name="bank_branch"
           value="{{ old('bank_branch', $leader->bank_branch) }}"
           required><br><br>

    <label>Account Number</label><br>
    <input type="text"
           name="account_number"
           value="{{ old('account_number', $leader->account_number) }}"
           required><br><br>

    <!-- CURRENT PHOTO -->
    <label>Current Photo</label><br>
    @if($leader->photo)
        <img src="{{ asset('storage/'.$leader->photo) }}" width="90"><br><br>
    @endif

    <!-- NEW PHOTO -->
    <input type="file" name="photo"><br><br>

    <!-- ATTACHMENTS -->
    <label>New Attachments</label><br>
    <input type="file" name="attachments[]" multiple><br><br>

    <!-- EXISTING ATTACHMENTS -->
    @if($leader->attachments)
        <label>Existing Attachments</label><br>

        @foreach($leader->attachments as $file)
            <a href="{{ asset('storage/'.$file) }}" target="_blank">
                View File
            </a><br>
        @endforeach

        <br>
    @endif

    <button type="submit"
            style="background:#FFC107; color:#fff; padding:8px 12px; border:none;">
        Update Leader
    </button>

</form>

@endsection