@extends('layouts.admin')

@section('content')

<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<div style="max-width:900px;margin:40px auto;background:#fff;padding:30px;border-radius:10px;">

    <h2>Create Committee</h2>

    <form method="POST" action="{{ route('admin.committees.store') }}" id="form">
        @csrf

        <!-- NAME -->
        <div style="margin-bottom:20px;">
            <label>Committee Name</label>
            <input type="text" name="name"
                   style="width:100%;padding:10px;border:1px solid #ccc;border-radius:6px;"
                   required>
        </div>

        <!-- EDITOR -->
        <div style="margin-bottom:20px;">
            <label>Overview</label>

            <!-- THIS IS THE EDITOR -->
            <div id="editor" style="height:400px;background:white;border:1px solid #ccc;"></div>

            <input type="hidden" name="overview" id="overview">
        </div>

        <button type="submit"
                style="background:black;color:white;padding:10px 18px;border:none;border-radius:6px;">
            Save
        </button>

    </form>

</div>

<!-- 🔥 LOAD QUILL DIRECTLY -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

<script>
window.onload = function () {

    // CHECK IF EDITOR EXISTS
    const editor = document.getElementById("editor");

    if (!editor) {
        alert("Editor container missing!");
        return;
    }

    // INIT QUILL
    const quill = new Quill('#editor', {
        theme: 'snow',
        placeholder: 'Start writing overview...',
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

    // MAKE SURE IT IS ACTIVE
    quill.focus();

    // SUBMIT HANDLER
    document.getElementById('form').onsubmit = function () {
        document.getElementById('overview').value = quill.root.innerHTML;
    };

};
</script>

@endsection