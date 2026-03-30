@extends('layouts.admin')

@section('content')
<h1>Edit Official Contact Info</h1>
<hr><br>

<form action="{{ route('admin.contact.update', $contact->id) }}" method="POST" style="max-width:600px;">
    @csrf
    @method('PUT')

    <div style="margin-bottom:15px;">
        <label for="website" style="font-weight:bold;">Website URL</label>
        <input type="url" id="website" name="website_url" value="{{ old('website_url', $contact->website_url) }}" 
               placeholder="https://example.com" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="official_email" style="font-weight:bold;">Official Email</label>
        <input type="email" id="official_email" name="official_email" value="{{ old('official_email', $contact->official_email) }}" required
               style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="customer_care_number" style="font-weight:bold;">Customer Care Number</label>
        <input type="text" id="customer_care_number" name="customer_care_number" value="{{ old('customer_care_number', $contact->customer_care_number) }}"
               style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="gs_pa_number" style="font-weight:bold;">GS PA Number</label>
        <input type="text" id="gs_pa_number" name="general_superintendent_pa_number" value="{{ old('general_superintendent_pa_number', $contact->general_superintendent_pa_number) }}"
               style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="postal_address" style="font-weight:bold;">Postal Address</label>
        <textarea id="postal_address" name="postal_address" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">{{ old('postal_address', $contact->postal_address) }}</textarea>
    </div>

    <div style="margin-bottom:15px;">
        <label for="working_hours" style="font-weight:bold;">Working Hours</label>
        <input type="text" id="working_hours" name="working_hours" value="{{ old('working_hours', $contact->working_hours) }}"
               style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
    </div>

    <div style="margin-bottom:15px;">
        <label for="google_map_embed_url" style="font-weight:bold;">Google Map Embed URL</label>
        <input type="url" id="google_map_embed_url" name="google_map_embed" value="{{ old('google_map_embed', $contact->google_map_embed) }}" 
               placeholder="Paste only the Google Maps 'src' URL" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
        <small>Example: https://www.google.com/maps/embed?pb=...</small>
    </div>

    <button type="submit" style="background:#2196F3; color:#fff; padding:10px 15px; border:none; border-radius:6px; cursor:pointer;">
        Update Contact Info
    </button>
</form>
@endsection
