@extends('layouts.app')

@section('content')

<div style="max-width:1100px; margin:auto; padding:20px;">

    {{-- TITLE --}}
    <h1 style="text-align:center; color:#1e3c72; text-transform:uppercase;">
        LEADERS OF {{ $district->name }} DISTRICT
    </h1>

    <div style="width:160px; height:4px; background:#FF9800; margin:10px auto 25px;"></div>

    {{-- DISTRICT INFO --}}
    <div style="background:#f8f9fa; padding:15px; border-radius:8px; margin-bottom:25px;">
        <p><strong>District:</strong> {{ $district->name }}</p>
        <p><strong>Overseer:</strong> {{ $district->overseer_name ?? 'Not Assigned' }}</p>
    </div>

    @php
        // POSITION PRIORITY ORDER
        $order = [
            'Overseer' => 1,
            'Secretary' => 2,
            'Treasurer' => 3,
            'Women Director' => 4,
            'Layperson' => 5,
            'CEYD' => 6,
            'Senior Pastor' => 7,
        ];

        // SORT ALL LEADERS BY POSITION ORDER
        $leaders = $district->leaders->sortBy(function($leader) use ($order) {
            return $order[$leader->position] ?? 999;
        });
    @endphp

    {{-- SINGLE HORIZONTAL GRID --}}
    <div style="
        display:grid;
        grid-template-columns:repeat(4, 1fr);
        gap:15px;
    ">

        @foreach($leaders as $leader)
            <div style="
                background:#fff;
                border:1px solid #ddd;
                border-radius:10px;
                padding:15px;
                text-align:center;
                box-shadow:0 2px 6px rgba(0,0,0,0.05);
                transition:0.3s;
            "
            onmouseover="this.style.transform='scale(1.03)'"
            onmouseout="this.style.transform='scale(1)'">

                {{-- PHOTO --}}
                <div>
                    @if($leader->photo)
                        <img src="{{ asset('storage/' . $leader->photo) }}"
                             style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #1e3c72;">
                    @else
                        <img src="https://via.placeholder.com/90"
                             style="width:90px; height:90px; border-radius:50%;">
                    @endif
                </div>

                {{-- NAME --}}
                <h4 style="margin:10px 0 5px; color:#333;">
                    {{ $leader->name }}
                </h4>

                {{-- POSITION --}}
                <p style="margin:0; color:#FF9800; font-weight:bold;">
                    {{ $leader->position }}
                </p>

                {{-- GENDER --}}
                <p style="margin:5px 0; font-size:13px; color:#666;">
                    {{ $leader->gender }}
                </p>

            </div>
        @endforeach

    </div>


</div>

{{-- RESPONSIVE --}}
<style>
@media (max-width: 1200px) {
    div[style*="grid-template-columns"] {
        grid-template-columns: repeat(3, 1fr) !important;
    }
}

@media (max-width: 768px) {
    div[style*="grid-template-columns"] {
        grid-template-columns: repeat(2, 1fr) !important;
    }
}

@media (max-width: 500px) {
    div[style*="grid-template-columns"] {
        grid-template-columns: repeat(1, 1fr) !important;
    }
}
</style>

@endsection