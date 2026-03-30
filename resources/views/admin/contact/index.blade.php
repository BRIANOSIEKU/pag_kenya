@extends('layouts.admin')

@section('content')
<!-- Back to Dashboard Button -->
<a href="{{ route('admin.dashboard') }}" 
   style="background-color:#808080; color:#fff; padding:8px 12px; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:20px;">
   Back to Dashboard
</a>

<h1>Official Church Contact Information</h1>
<hr><br>

<div style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">
    @if($contact)
        <a href="{{ route('admin.contact.edit', $contact->id) }}" 
           style="background-color:#4CAF50; color:#fff; padding:8px 12px; border-radius:6px;">
           Edit Contact Info
        </a>

        <form method="POST" action="{{ route('admin.contact.destroy', $contact->id) }}" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" style="background-color:#F44336; color:#fff; padding:8px 12px; border:none; border-radius:6px;">
                Delete Contact Info
            </button>
        </form>
    @else
        <a href="{{ route('admin.contact.create') }}" 
           style="background-color:#2196F3; color:#fff; padding:8px 12px; border-radius:6px;">
           Add Contact Info
        </a>
    @endif
</div>

@if($contact)
<div style="display:flex; flex-wrap:wrap; gap:20px;">

    <div style="flex:1; min-width:250px;">
        <h4>Website URL</h4>
        <p><a href="{{ $contact->website_url }}" target="_blank">{{ $contact->website_url }}</a></p>

        <h4>Official Email</h4>
        <p>{{ $contact->official_email }}</p>

        <h4>Phone Numbers</h4>
        @if($contact->customer_care_number)
            <p>Customer Care: {{ $contact->customer_care_number }}</p>
        @endif
        @if($contact->general_superintendent_pa_number)
            <p>GS PA: {{ $contact->general_superintendent_pa_number }}</p>
        @endif

        <h4>Postal Address</h4>
        <p>{{ $contact->postal_address }}</p>

        <h4>Working Hours</h4>
        <p>{{ $contact->working_hours }}</p>
    </div>

    <div style="flex:1; min-width:300px;">
        <h4>Location / Google Map</h4>
        @if($contact->google_map_embed)
            <iframe src="{{ $contact->google_map_embed }}" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        @endif
    </div>

</div>
@endif
@endsection
