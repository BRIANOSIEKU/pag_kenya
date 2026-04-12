@extends('layouts.district_admin')

@section('content')

<div style="max-width:900px;margin:auto;">

    <h2>Notifications</h2>

    <form method="POST" action="{{ route('district.admin.notifications.read.all') }}">
        @csrf
        <button style="background:green;color:#fff;padding:8px 12px;border:none;margin-bottom:15px;">
            Mark All as Read
        </button>
    </form>

    @forelse($notifications as $note)

        <div style="
            padding:12px;
            margin-bottom:10px;
            border-radius:6px;
            background: {{ $note->is_read ? '#f1f1f1' : '#fff3cd' }};
            border-left:5px solid {{ $note->is_read ? '#ccc' : '#ff9800' }};
        ">

            <strong>{{ $note->title }}</strong>
            <p style="margin:5px 0;">{{ $note->message }}</p>

            <small>{{ $note->created_at->diffForHumans() }}</small>

            @if(!$note->is_read)
                <form method="POST"
                      action="{{ route('district.admin.notifications.read', $note->id) }}"
                      style="margin-top:5px;">
                    @csrf
                    <button style="background:#007bff;color:#fff;border:none;padding:5px 10px;">
                        Mark as Read
                    </button>
                </form>
            @endif

        </div>

    @empty
        <p>No notifications found.</p>
    @endforelse

</div>

@endsection