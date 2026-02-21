@extends('layouts.admin')

@section('content')

<!-- Back to Departments Button -->
<div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <a href="{{ route('admin.departments.index') }}" style="
        background-color:#9C27B0;
        color:#fff;
        padding:10px 16px;
        border-radius:6px;
        font-weight:bold;
        text-decoration:none;
        transition:0.3s;
    "
    onmouseover="this.style.opacity='0.8'"
    onmouseout="this.style.opacity='1'"
    >&larr; Back to Departments</a>

    <h1 style="margin:0;">Department Details: {{ $department->name }}</h1>
</div>

<div style="display:flex; gap:40px; margin-bottom:30px;">
    <!-- Photo Section -->
    <div>
        @if($department->photo)
            <img src="{{ asset('storage/departments_photos/'.$department->photo) }}" 
                 alt="{{ $department->name }}" 
                 style="width:250px; height:auto; border:1px solid #ccc; padding:5px;">
        @else
            <p>No Photo Available</p>
        @endif
    </div>

    <!-- Details Section -->
    <div style="flex:1;">
        <p><strong>1. Name:</strong> {{ $department->name }}</p>
        <p><strong>2. Leadership:</strong> {{ $department->leadership }}</p>

        <hr>
        <h4>3. Overview</h4>
        <div style="margin-left:15px;">
            @foreach(explode("\n", $department->overview) as $line)
                @if(trim($line))
                    @php $parts = explode(':', $line, 2); @endphp
                    @if(count($parts) == 2)
                        <strong>{{ trim($parts[0]) }}:</strong>
                        <ul>
                            <li>{{ trim($parts[1]) }}</li>
                        </ul>
                    @else
                        <p>{{ trim($line) }}</p>
                    @endif
                @endif
            @endforeach
        </div>

        <h4>4. Activities</h4>
        <div style="margin-left:15px;">
            @foreach(explode("\n", $department->activities) as $line)
                @if(trim($line))
                    @php $parts = explode(':', $line, 2); @endphp
                    @if(count($parts) == 2)
                        <strong>{{ trim($parts[0]) }}:</strong>
                        <ul>
                            <li>{{ trim($parts[1]) }}</li>
                        </ul>
                    @else
                        <p>{{ trim($line) }}</p>
                    @endif
                @endif
            @endforeach
        </div>

        <h4>5. Description</h4>
        <div style="margin-left:15px;">
            @foreach(explode("\n", $department->description) as $line)
                @if(trim($line))
                    @php $parts = explode(':', $line, 2); @endphp
                    @if(count($parts) == 2)
                        <strong>{{ trim($parts[0]) }}:</strong>
                        <ul>
                            <li>{{ trim($parts[1]) }}</li>
                        </ul>
                    @else
                        <p>{{ trim($line) }}</p>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>

<hr>

<h3>Documents</h3>
<ul>
    @foreach($department->documents as $doc)
        <li>
            <a href="{{ asset('storage/departments_documents/'.$doc->file_path) }}" target="_blank">
                {{ $doc->name }}
            </a>
            <form action="{{ route('admin.departments.deleteDocument', $doc->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
            </form>
        </li>
    @endforeach
</ul>

<h4>Upload New Document</h4>
<form action="{{ route('admin.departments.uploadDocument', $department->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="document" required style="margin-bottom:10px;">
    <input type="text" name="name" placeholder="Document Name" required style="margin-bottom:10px;">
    <button type="submit" class="btn btn-success">Upload</button>
</form>

<hr>

{{-- Achievements Section --}}
<h3 style="display:flex; justify-content:space-between; align-items:center;">
    Achievements
    <button id="toggleAchievementForm" style="
        background:#4CAF50;
        color:#fff;
        border:none;
        padding:6px 12px;
        border-radius:6px;
        cursor:pointer;
    ">+ Add New Achievement</button>
</h3>

{{-- Hidden Form --}}
<div id="achievementForm" style="display:none; margin-top:15px; margin-bottom:25px; border:1px solid #ccc; padding:15px; border-radius:6px;">
    <form action="{{ route('admin.departments.achievements.store', $department->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom:10px;">
            <input type="text" name="name" placeholder="Achievement Name" required style="width:100%; padding:6px;">
        </div>
        <div style="margin-bottom:10px;">
            <textarea name="description" placeholder="Description" rows="3" style="width:100%; padding:6px;"></textarea>
        </div>
        <div style="margin-bottom:10px;">
            <input type="date" name="date" style="width:100%; padding:6px;">
        </div>
        <div style="margin-bottom:10px;">
            <input type="file" name="photo" accept="image/*" style="width:100%; padding:6px;">
        </div>
        <button type="submit" class="btn btn-primary">Save Achievement</button>
    </form>
</div>

{{-- Achievements Table --}}
<table style="width:100%; border-collapse: collapse; margin-top:15px;">
    <thead>
        <tr style="background:#f5f5f5; text-align:left;">
            <th style="padding:10px; border-bottom:1px solid #ddd;">Photo</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Name</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Description</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Date</th>
            <th style="padding:10px; border-bottom:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($department->achievements as $achievement)
            <tr>
                <td style="padding:10px; border-bottom:1px solid #ddd;">
                    @if($achievement->photo && Storage::disk('public')->exists('departments_achievements/'.$achievement->photo))
                        <img src="{{ Storage::url('departments_achievements/'.$achievement->photo) }}" 
                             alt="Photo" style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                    @else
                        <span style="color:#888;">No Photo</span>
                    @endif
                </td>
                <td style="padding:10px; border-bottom:1px solid #ddd;">{{ $achievement->name }}</td>
                <td style="padding:10px; border-bottom:1px solid #ddd;">{{ $achievement->description }}</td>
                <td style="padding:10px; border-bottom:1px solid #ddd;">
                    {{ $achievement->date ? \Carbon\Carbon::parse($achievement->date)->format('d M Y') : '-' }}
                </td>
                <td style="padding:10px; border-bottom:1px solid #ddd;">
                    <form action="{{ route('admin.departments.achievements.destroy', $achievement->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="padding:10px; text-align:center; color:#888;">No achievements yet.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{-- Toggle Form Script --}}
<script>
    document.getElementById('toggleAchievementForm').addEventListener('click', function() {
        var form = document.getElementById('achievementForm');
        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
</script>

@endsection
