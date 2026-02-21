@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Church Council Members</h2>

    {{-- Success Message --}}
    @if(session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Add New Member Button --}}
    <a href="{{ route('admin.leadership.create', 'council') }}" 
       style="display:inline-block; margin-bottom:15px; background-color:#2196F3; color:#fff; padding:10px 20px; border-radius:5px; text-decoration:none;">
       Add New Member
    </a>

    {{-- Members Table --}}
    <table style="width:100%; border-collapse:collapse; border:1px solid #ccc;">
        <thead style="background-color:#f2f2f2;">
            <tr>
                <th style="padding:10px; border:1px solid #ccc;">Photo</th>
                <th style="padding:10px; border:1px solid #ccc;">Full Name</th>
                <th style="padding:10px; border:1px solid #ccc;">Position</th>
                <th style="padding:10px; border:1px solid #ccc;">Contact</th>
                <th style="padding:10px; border:1px solid #ccc;">Email</th>
                <th style="padding:10px; border:1px solid #ccc;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($leaders as $leader)
                <tr>
                    <td style="text-align:center; padding:10px; border:1px solid #ccc;">
                        @if($leader->photo)
                            <img src="{{ asset($leader->photo) }}" alt="{{ $leader->full_name }}" style="height:60px; border-radius:5px;">
                        @endif
                    </td>
                    <td style="padding:10px; border:1px solid #ccc;">{{ $leader->full_name }}</td>
                    <td style="padding:10px; border:1px solid #ccc;">{{ $leader->position }}</td>
                    <td style="padding:10px; border:1px solid #ccc;">{{ $leader->contact }}</td>
                    <td style="padding:10px; border:1px solid #ccc;">{{ $leader->email }}</td>
                    <td style="padding:10px; border:1px solid #ccc; display:flex; gap:5px; justify-content:center;">
                        <a href="{{ route('admin.leadership.edit', ['council', $leader->id]) }}" 
                           style="background-color:#FFC107; color:#fff; padding:5px 10px; border-radius:5px; text-decoration:none;">
                           Edit
                        </a>
                        <form action="{{ route('admin.leadership.destroy', ['council', $leader->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    style="background-color:#F44336; color:#fff; padding:5px 10px; border:none; border-radius:5px; cursor:pointer;">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:15px;">No Church Council members found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
