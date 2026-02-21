@extends('admin.layouts.app')

@section('content')
<div class="container py-4">

    <h3 class="mb-4">Live Stream Details</h3>

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="text-center mb-4">
                @if($livestream->logo)
                    <img src="{{ asset('storage/' . $livestream->logo) }}"
                         alt="Logo"
                         style="max-height:120px;">
                @endif
            </div>

            <table class="table table-bordered">
                <tr>
                    <th>Title</th>
                    <td>{{ $livestream->title }}</td>
                </tr>

                <tr>
                    <th>Description</th>
                    <td>{{ $livestream->description }}</td>
                </tr>

                <tr>
                    <th>Status</th>
                    <td>
                        @if($livestream->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <th>Created At</th>
                    <td>{{ $livestream->created_at->format('d M Y H:i') }}</td>
                </tr>
            </table>

            <div class="mt-4">
                <h5>Embed Preview</h5>
                <div class="ratio ratio-16x9">
                    {!! $livestream->embed_code !!}
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('admin.livestreams.edit', $livestream) }}"
                   class="btn btn-primary">
                    Edit
                </a>

                <a href="{{ route('admin.livestreams.index') }}"
                   class="btn btn-secondary">
                    Back
                </a>
            </div>

        </div>
    </div>

</div>
@endsection