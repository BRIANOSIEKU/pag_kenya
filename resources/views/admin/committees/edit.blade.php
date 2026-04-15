@extends('layouts.admin')

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="max-width:900px; margin:40px auto; background:#fff; padding:30px; border-radius:10px; box-shadow:0 2px 10px rgba(0,0,0,0.08);">

    <h2 style="margin-bottom:20px; font-size:26px; font-weight:bold;">
        Edit Committee
    </h2>

    <form method="POST" action="{{ route('admin.committees.update', $committee->id) }}" id="form">
        @csrf
        @method('PUT')

        <!-- NAME -->
        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:bold; margin-bottom:6px;">
                Committee Name
            </label>

            <input type="text" name="name"
                   value="{{ $committee->name }}"
                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px;"
                   required>
        </div>

        <!-- OVERVIEW -->
        <div style="margin-bottom:20px;">
            <label style="display:block; font-weight:bold; margin-bottom:6px;">
                Overview
            </label>

            <!-- QUILL EDITOR -->
            <div id="editor"
                 style="height:400px; background:white; border:1px solid #ccc; border-radius:6px;">
            </div>

            <input type="hidden" name="overview" id="overview">
        </div>

        <!-- BUTTON -->
        <div style="display:flex; gap:10px; align-items:center;">
            <button type="submit"
                    style="background:#000; color:#fff; padding:10px 18px; border:none; border-radius:6px; cursor:pointer;">
                Update Committee
            </button>

            <a href="{{ route('admin.committees.index') }}"
               style="color:#555; text-decoration:none;">
                Cancel
            </a>
        </div>

    </form>

</div>

<!-- QUILL JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
window.onload = function () {

    const editor = document.getElementById("editor");

    if (!editor) {
        console.error("Editor container missing!");
        return;
    }

    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Edit overview...',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline'],
                [{ header: [1, 2, 3, false] }],
                [{ list: 'ordered' }, { list: 'bullet' }],
                [{ color: [] }, { background: [] }],
                ['clean']
            ]
        }
    });

    // Load existing content safely
    quill.root.innerHTML = `{!! $committee->overview !!}`;

    quill.focus();

    document.getElementById('form').onsubmit = function () {
        document.getElementById('overview').value = quill.root.innerHTML;
    };

};
</script>

@endsection