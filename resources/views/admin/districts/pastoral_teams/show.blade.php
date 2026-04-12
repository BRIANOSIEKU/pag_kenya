@extends('layouts.admin')

@section('content')

<div style="max-width:900px;margin:auto;">

    <h2 style="margin-bottom:20px;">Pastoral Team Member Profile</h2>

    <div style="background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.1);">

        <!-- BACK BUTTON -->
        <a href="{{ route('admin.districts.pastoral-teams.index', $pastor->district_id) }}"
           style="display:inline-block;margin-bottom:15px;padding:6px 10px;background:#555;color:#fff;border-radius:4px;text-decoration:none;">
            ← Back to Pastoral Team List
        </a>

        <!-- HEADER -->
        <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;">

            <img src="{{ $pastor->photo ? asset('storage/' . $pastor->photo) : 'https://via.placeholder.com/120' }}"
                 style="width:120px;height:120px;border-radius:50%;object-fit:cover;">

            <div>
                <h2>{{ $pastor->name }}</h2>
                <p><strong>Gender:</strong> {{ $pastor->gender }}</p>
                <p><strong>Contact:</strong> {{ $pastor->contact }}</p>
                <p><strong>National ID:</strong> {{ $pastor->national_id }}</p>
            </div>

        </div>

        <hr style="margin:20px 0;">

        <!-- DETAILS GRID -->
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:15px;">

            <div>
                <strong>District</strong><br>
                {{ $pastor->district->name ?? 'N/A' }}
            </div>

            <div>
                <strong>Assembly</strong><br>
                {{ $pastor->assembly->name ?? 'N/A' }}
            </div>

            <div>
                <strong>Year of Graduation</strong><br>
                {{ $pastor->graduation_year ?? 'N/A' }}
            </div>

            <div>
                <strong>Date of Birth</strong><br>
                {{ $pastor->date_of_birth ? \Carbon\Carbon::parse($pastor->date_of_birth)->format('d M Y') : 'N/A' }}
            </div>

        </div>

        <hr style="margin:20px 0;">

        <!-- CREDENTIALS -->
        <div>
            <h3>Credentials</h3>

            @php
                $files = $pastor->attachments ? json_decode($pastor->attachments, true) : [];
            @endphp

            @if(!empty($files) && count($files))
                <ul>
                    @foreach($files as $file)
                        <li>
                            <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                📄 View Credentials
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No credentials available.</p>
            @endif
        </div>

    </div>

</div>

@endsection