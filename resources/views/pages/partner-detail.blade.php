@extends('layouts.app') <!-- Or your public layout -->

@section('content')

<!-- ================= PARTNER DETAIL ================= -->
<section id="partner-detail" style="padding:60px 20px; background:#f9f9f9;">
    <div style="max-width:900px; margin:0 auto;">

        <!-- Partner Name -->
        <h1 style="font-family:'Playfair Display', serif; font-weight:700; color:#0f3c78; margin-bottom:20px; text-align:center;">
            {{ $partner->name }}
        </h1>

        <!-- Partner Logo -->
        @if($partner->logo)
            <div style="text-align:center; margin-bottom:30px;">
                <img src="{{ asset('storage/'.$partner->logo) }}" 
                     alt="{{ $partner->name }}" 
                     style="max-width:300px; width:100%; height:auto; border-radius:8px; border:1px solid #ddd; object-fit:contain;">
            </div>
        @endif

        <!-- Partner Description -->
        <div style="font-family:'Inter', sans-serif; color:#333; line-height:1.7; margin-bottom:30px; text-align:center;">
            {!! nl2br(e($partner->description)) !!}
        </div>

        <!-- Back Button -->
        <a href="{{ route('partners.index') }}" 
           style="display:inline-block; padding:10px 16px; background:#2196F3; color:#fff; border-radius:6px; text-decoration:none; transition:0.3s;"
           onmouseover="this.style.backgroundColor='#0f3c78';"
           onmouseout="this.style.backgroundColor='#2196F3';">
            ← Back to Partners
        </a>

    </div>
</section>

@endsection
