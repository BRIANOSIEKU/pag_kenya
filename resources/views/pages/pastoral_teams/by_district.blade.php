@extends('layouts.app')

@section('content')
<div style="max-width:1000px; margin:auto; padding:20px;">

    {{-- Back Button --}}
    <div style="margin-bottom:20px;">
        <a href="{{ url()->previous() }}" 
           style="padding:8px 15px; background:#FF9800; color:#fff; border-radius:4px; text-decoration:none;">
            ← Back
        </a>
    </div>

    {{-- Page Title --}}
    <h1 style="text-align:center; color:#1e3c72; margin-bottom:10px; font-size:2em;">
        Pastoral Team in {{ $district }}
    </h1>
    <div style="width:120px; height:4px; background:#FF9800; margin:0 auto 30px auto; border-radius:2px;"></div>

    @if($teams->count() > 0)
        <table style="width:100%; border-collapse:collapse; box-shadow:0 0 10px rgba(0,0,0,0.1);">
            <thead>
                <tr style="background:#f5f5f5; text-align:left;">
                    <th style="padding:10px; border:1px solid #ddd; width:40px;">#</th>
                    <th style="padding:10px; border:1px solid #ddd; width:80px;">Photo</th>
                    <th style="padding:10px; border:1px solid #ddd;">Name</th>
                    <th style="padding:10px; border:1px solid #ddd;">Assembly</th>
                    <th style="padding:10px; border:1px solid #ddd;">Role</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teams as $index => $team)
                    <tr>
                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">
                            {{ $index + 1 }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd; width:80px;">
                            @if($team->photo)
                                <img src="{{ asset('storage/'.$team->photo) }}" 
                                     alt="{{ $team->name }}" 
                                     width="60" height="60" 
                                     style="object-fit:cover; border-radius:50%; border:1px solid #ccc;">
                            @else
                                <div style="width:60px; height:60px; background:#ccc; border-radius:50%;"></div>
                            @endif
                        </td>
                        <td style="padding:10px; border:1px solid #ddd; font-weight:bold;">
                            {{ $team->name }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $team->assembly_name }}
                        </td>
                        <td style="padding:10px; border:1px solid #ddd;">
                            {{ $team->role ?? '-' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align:center; color:#777;">No pastoral team members found in this district.</p>
    @endif

</div>
@endsection