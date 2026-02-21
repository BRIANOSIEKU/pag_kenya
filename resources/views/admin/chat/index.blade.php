@extends('layouts.admin')

@section('title', 'Admin Chat Management')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Admin Chat Management</h1>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- Chat Table --}}
    @if($chats->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle shadow-sm">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Sent At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chats as $key => $chat)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td>{{ $chat->user_name }}</td>
                            <td>{{ $chat->email }}</td>
                            <td>{{ Str::limit($chat->message, 50) }}</td>
                            <td>{{ $chat->created_at->format('d M Y, h:i A') }}</td>
                            <td class="text-center">

                                {{-- Delete Button --}}
                                <form action="{{ url('admin/chat/delete/'.$chat->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this chat message?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm mb-1">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>

                                {{-- Reply Button --}}
                                <form action="{{ url('admin/chat/reply/'.$chat->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm mb-1">
                                        <i class="bi bi-reply"></i> Reply
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-3">
            {{ $chats->links() }}
        </div>
    @else
        <div class="alert alert-info text-center">No chat messages found.</div>
    @endif

    {{-- Optional Floating Chat Reply Panel --}}
    <div class="floating-chat mt-5">
        <h5 class="mb-3">Send Quick Reply</h5>
        <form action="{{ url('admin/chat/reply/0') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="text" name="user_email" class="form-control" placeholder="User Email" required>
            </div>
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="3" placeholder="Type your reply here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Send Reply</button>
        </form>
    </div>
</div>

{{-- Bootstrap Icons --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

{{-- Optional Mobile-Friendly Styling --}}
<style>
    .table td, .table th {
        vertical-align: middle;
    }
    @media(max-width: 575px) {
        .btn-sm {
            width: 100%;
            margin-bottom: 0.25rem;
        }
        .floating-chat {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
    }
    .floating-chat h5 {
        text-align: center;
    }
</style>
@endsection