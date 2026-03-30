@extends('layouts.admin')

@section('title', 'Comments Moderation')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-dark text-white">
            <h4 class="mb-0">Comments Moderation</h4>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table id="commentsTable" class="table table-bordered table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Devotion</th>
                        <th>User</th>
                        <th>Comment</th>
                        <th>Status</th>
                        <th>Admin Reply</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($comments as $comment) <!-- Use $comments here -->
                        <tr>
                            <td>{{ $comment->id }}</td>
                            <td>{{ $comment->devotion->title ?? 'N/A' }}</td>
                            <td>
                                <strong>{{ $comment->user->name ?? 'N/A' }}</strong><br>
                                <small>{{ $comment->user->email ?? '' }}</small>
                            </td>
                            <td>{{ $comment->comment }}</td>
                            <td>
                                @if($comment->admin_response)
                                    <span class="badge bg-success">Replied</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                            <td>{{ $comment->admin_response ?? '---' }}</td>
                            <td style="min-width: 250px;">

                                {{-- Reply / Update Form --}}
                                <form action="{{ route('admin.comments.respond', $comment->id) }}" method="POST">
                                    @csrf
                                    <div class="mb-2">
                                        <textarea name="admin_response"
                                                  class="form-control"
                                                  rows="2"
                                                  placeholder="Write response..."
                                                  required>{{ $comment->admin_response }}</textarea>
                                    </div>
                                    <button class="btn btn-sm btn-primary">
                                        {{ $comment->admin_response ? 'Update' : 'Reply' }}
                                    </button>
                                </form>

                                {{-- Delete Form --}}
                                <form action="{{ route('admin.comments.delete', $comment->id) }}"
                                      method="POST"
                                      class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this comment?')">
                                        Delete
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function () {
    $('#commentsTable').DataTable({
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100],
        "order": [[0, 'desc']],
        "columnDefs": [
            { "orderable": false, "targets": 6 } // Disable ordering on Actions column
        ]
    });
});
</script>
@endsection