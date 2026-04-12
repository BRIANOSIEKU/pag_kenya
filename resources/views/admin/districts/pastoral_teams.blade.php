@extends('layouts.admin')

@section('content')

<h2 style="margin-bottom:15px;">
    {{ $district->name }} - Pastoral Team
</h2>

<a href="{{ route('admin.districts.index') }}"
   style="display:inline-block;margin-bottom:15px;padding:8px 12px;
          background:#555;color:#fff;border-radius:6px;text-decoration:none;">
    ← Back to Districts
</a>

@if(session('success'))
    <div style="background:#d4edda;padding:10px;color:#155724;margin-bottom:10px;border-radius:6px;">
        {{ session('success') }}
    </div>
@endif

@if($district->pastoralTeam->count())

    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:15px;">

        @foreach($district->pastoralTeam as $pastor)

            <div style="background:#fff;border:1px solid #e5e5e5;border-radius:10px;
                        padding:15px;box-shadow:0 2px 6px rgba(0,0,0,0.05);">

                {{-- PHOTO --}}
                <div style="text-align:center;margin-bottom:10px;">
                    @if($pastor->photo)
                        <img src="{{ asset('storage/' . $pastor->photo) }}"
                             style="width:90px;height:90px;border-radius:10px;object-fit:cover;">
                    @else
                        <div style="width:90px;height:90px;border-radius:10px;background:#ddd;margin:auto;"></div>
                    @endif
                </div>

                {{-- INFO --}}
                <h3 style="margin:0;text-align:center;">
                    {{ $pastor->name }}
                </h3>

                <p style="text-align:center;color:#666;margin:5px 0;">
                    {{ $pastor->gender }}
                </p>

                <hr>

                <p><b>Phone:</b> {{ $pastor->contact }}</p>
                <p><b>National ID:</b> {{ $pastor->national_id }}</p>
                <p><b>DOB:</b> {{ $pastor->date_of_birth }}</p>
                <p><b>Graduation:</b> {{ $pastor->graduation_year }}</p>

                <p><b>Assembly ID:</b> {{ $pastor->current_assembly_id ?? 'N/A' }}</p>

                {{-- ATTACHMENTS --}}
                <div style="margin-top:10px;">
                    <b>Documents:</b><br>

                    @if($pastor->attachments)
                        @php
                            $files = json_decode($pastor->attachments, true);
                        @endphp

                        @if(is_array($files))
                            @foreach($files as $file)
                                <div>
                                    📎 <a href="{{ asset('storage/' . $file) }}" target="_blank">
                                        View Document
                                    </a>
                                </div>
                            @endforeach
                        @else
                            📎 <a href="{{ asset('storage/' . $pastor->attachments) }}" target="_blank">
                                View Document
                            </a>
                        @endif
                    @else
                        <span style="color:#888;">No attachments</span>
                    @endif
                </div>

            </div>

        @endforeach

    </div>

@else

    <div style="background:#fff;padding:15px;border-radius:8px;">
        No pastoral team members found in this district.
    </div>

@endif

@endsection