@extends('layouts.admin')

@section('content')

<h2>Ministry Partners</h2>

<a href="{{ route('admin.partners.create') }}"
   style="background:#4CAF50;color:#fff;padding:8px 15px;border-radius:6px;text-decoration:none;">
   + Add Partner
</a>

<br><br>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(250px,1fr));gap:20px;">

@foreach($partners as $partner)
    <div style="border:1px solid #ddd;padding:15px;border-radius:10px;background:#fff;box-shadow:0 3px 10px rgba(0,0,0,0.08);">

        @if($partner->logo)
            <img src="{{ asset('storage/'.$partner->logo) }}" 
                 style="width:100%;height:120px;object-fit:contain;margin-bottom:10px;">
        @endif

        <h4>{{ $partner->name }}</h4>
        <p>{{ Str::limit($partner->description, 80) }}</p>

        <div style="margin-top:10px;">
            <a href="{{ route('admin.partners.show', $partner) }}">View</a> |
            <a href="{{ route('admin.partners.edit', $partner) }}">Edit</a> |

            <form action="{{ route('admin.partners.destroy', $partner) }}" 
                  method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Delete partner?')" 
                        style="background:none;border:none;color:red;cursor:pointer;">
                    Delete
                </button>
            </form>
        </div>

    </div>
@endforeach

</div>

@endsection
