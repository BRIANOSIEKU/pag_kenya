@extends('layouts.app')

@section('content')

<div style="max-width:1100px; margin:auto; padding:20px;">

    {{-- TITLE --}}
    <h1 style="text-align:center; color:#1e3c72; text-transform:uppercase;">
        PASTORAL TEAM OF {{ $district->name }} DISTRICT
    </h1>

    <div style="width:160px; height:4px; background:#FF9800; margin:10px auto 25px;"></div>

    {{-- DISTRICT INFO --}}
    <div style="background:#f8f9fa; padding:15px; border-radius:8px; margin-bottom:25px;">
        <p><strong>District:</strong> {{ $district->name }}</p>
        <p><strong>Overseer:</strong> {{ $district->overseer_name ?? 'Not Assigned' }}</p>
    </div>

    {{-- TEAM --}}
    @if($teams->count() > 0)

        <div style="
            display:grid;
            grid-template-columns:repeat(4, 1fr);
            gap:15px;
        ">

            @foreach($teams as $member)
                <div style="
                    background:#fff;
                    border:1px solid #ddd;
                    border-radius:10px;
                    padding:15px;
                    text-align:center;
                    box-shadow:0 2px 6px rgba(0,0,0,0.05);
                    transition:0.3s;
                    position:relative;
                "
                onmouseover="this.style.transform='scale(1.03)'"
                onmouseout="this.style.transform='scale(1)'">

                    {{-- NUMBERING BADGE --}}
                    <div style="
                        position:absolute;
                        top:10px;
                        left:10px;
                        background:#1e3c72;
                        color:#fff;
                        width:28px;
                        height:28px;
                        border-radius:50%;
                        display:flex;
                        align-items:center;
                        justify-content:center;
                        font-size:13px;
                        font-weight:bold;
                    ">
                        {{ $loop->iteration }}
                    </div>

                    {{-- PHOTO --}}
                    <div>
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}"
                                 style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid #1e3c72;">
                        @else
                            <img src="https://via.placeholder.com/90"
                                 style="width:90px; height:90px; border-radius:50%;">
                        @endif
                    </div>

                    {{-- NAME --}}
                    <h4 style="margin:10px 0 5px; color:#333;">
                        {{ $member->name }}
                    </h4>

                    {{-- ASSEMBLY --}}
                    <p style="margin:0; font-size:13px; color:#666;">
                        <strong>Assembly:</strong>
                        {{ $member->assembly->name ?? 'Not Assigned' }}
                    </p>

                    {{-- GENDER --}}
                    <p style="margin:5px 0; font-size:13px; color:#666;">
                        <strong>Gender:</strong>
                        {{ $member->gender }}
                    </p>

                </div>
            @endforeach

        </div>

    @else
        <p style="text-align:center; color:#777;">
            No pastoral team members found for this district.
        </p>
    @endif


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