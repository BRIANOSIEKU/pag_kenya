@extends('layouts.admin')

@section('content')
<h1>Edit Official Contact Info</h1>
<hr><br>

<form action="{{ route('admin.contact.update', $contact->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Website</label>
        <input type="url" name="website_url" value="{{ old('website_url', $contact->website_url) }}" placeholder="https://example.com">
    </div>

    <div>
        <label>Official Email</label>
        <input type="email" name="official_email" value="{{ old('official_email', $contact->official_email) }}" required>
    </div>

    <div>
        <label>Customer Care Number</label>
        <input type="text" name="customer_care_number" value="{{ old('customer_care_number', $contact->customer_care_number) }}">
    </div>

    <div>
        <label>General Superintendent PA Number</label>
        <input type="text" name="general_superintendent_pa_number" value="{{ old('general_superintendent_pa_number', $contact->general_superintendent_pa_number) }}">
    </div>

    <div>
        <label>Postal Address</label>
        <textarea name="postal_address">{{ old('postal_address', $contact->postal_address) }}</textarea>
    </div>

    <div>
        <label>Working Hours</label>
        <input type="text" name="working_hours" value="{{ old('working_hours', $contact->working_hours) }}">
    </div>

    <div>
        <label>Google Map Embed URL</label>
        <input type="url" name="google_map_embed" value="{{ old('google_map_embed', $contact->google_map_embed) }}" 
            placeholder="Paste only the Google Maps embed src URL">
        <small>Example: https://www.google.com/maps/embed?pb=...</small>
    </div>

    <br>
    <button type="submit" style="background:#4CAF50; color:#fff; padding:10px; border:none; border-radius:6px;">Update</button>
</form>
@endsection
