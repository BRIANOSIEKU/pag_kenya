@extends('layouts.app') <!-- Or your public layout -->

@section('content')

<!-- ================= PARTNERS ================= -->
<section id="partners" style="padding:60px 20px; background:#f9f9f9;">
    <div style="max-width:1200px; margin:0 auto;">
        <h1 style="font-family:'Playfair Display', serif; font-weight:700; color:#0f3c78; margin-bottom:30px; text-align:center;">
            Our Ministry Partners
        </h1>

        @php
            use App\Models\Partner;
            $allPartners = Partner::latest()->get(); // fetch all partners
        @endphp

        <!-- Grid for small square cards -->
        <div style="display:grid; grid-template-columns:repeat(6, 1fr); gap:15px;">

            @foreach($allPartners as $partner)
                <a href="{{ route('partners.show', $partner->id) }}" style="text-decoration:none;">
                    <div style="
                        background:#fff;
                        border-radius:8px;
                        box-shadow:0 2px 8px rgba(0,0,0,0.05);
                        display:flex;
                        flex-direction:column;
                        justify-content:center;
                        align-items:center;
                        aspect-ratio:1/1;
                        padding:10px;
                        transition:0.3s;
                        text-align:center;
                        overflow:hidden;
                        color: inherit;
                    "
                         onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)';"
                         onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.05)';"
                    >
                        @if($partner->logo)
                            <img src="{{ asset('storage/'.$partner->logo) }}" 
                                 alt="{{ $partner->name }}" 
                                 style="width:60%; height:60%; object-fit:contain; margin-bottom:8px;">
                        @endif

                        <h5 style="font-family:'Playfair Display', serif; font-weight:600; color:#1e3c72; font-size:0.85rem; margin:0;">
                            {{ $partner->name }}
                        </h5>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
</section>

@endsection
