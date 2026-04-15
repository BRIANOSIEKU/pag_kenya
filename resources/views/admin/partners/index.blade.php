@extends('layouts.admin')

@section('content')

<style>
.container {
    max-width: 1100px;
    margin: auto;
    padding: 15px;
}

/* HEADER */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

/* BUTTONS */
.btn {
    padding: 8px 14px;
    border-radius: 6px;
    text-decoration: none;
    font-weight: bold;
    font-size: 13px;
    display: inline-block;
}
.btn-primary {
    background: #4CAF50;
    color: #fff;
}
.btn:hover {
    opacity: 0.85;
}

/* SUCCESS MESSAGE */
.alert-success {
    background: #d4edda;
    color: #155724;
    padding: 10px;
    border-radius: 6px;
    margin-bottom: 15px;
}

/* GRID */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
}

/* CARD */
.card {
    background: #fff;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.08);
    border: 1px solid #eee;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* IMAGE */
.card img {
    width: 100%;
    height: 120px;
    object-fit: contain;
    margin-bottom: 10px;
}

/* TITLE */
.card h4 {
    margin: 5px 0;
}

/* DESCRIPTION */
.card p {
    font-size: 14px;
    color: #555;
}

/* ACTIONS */
.actions {
    margin-top: 10px;
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}
.actions a,
.actions button {
    font-size: 12px;
    border-radius: 5px;
    padding: 4px 8px;
    text-decoration: none;
    border: none;
    cursor: pointer;
}

.btn-view { background:#2196F3; color:#fff; }
.btn-edit { background:#FFC107; color:#fff; }
.btn-delete { background:#F44336; color:#fff; }

/* RESPONSIVE */
@media(max-width:768px){
    .header {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
}
</style>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h2>Ministry Partners</h2>

        <a href="{{ route('admin.partners.create') }}" class="btn btn-primary">
            + Add Partner
        </a>
    </div>

    <!-- SUCCESS -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- GRID -->
    <div class="grid">

        @foreach($partners as $partner)
            <div class="card">

                <!-- LOGO -->
                @if($partner->logo)
                    <img src="{{ asset('storage/'.$partner->logo) }}" alt="Logo">
                @endif

                <!-- INFO -->
                <div>
                    <h4>{{ $partner->name }}</h4>
                    <p>{{ \Illuminate\Support\Str::limit($partner->description, 80) }}</p>
                </div>

                <!-- ACTIONS -->
                <div class="actions">
                    <a href="{{ route('admin.partners.show', $partner) }}" class="btn-view">View</a>
                    <a href="{{ route('admin.partners.edit', $partner) }}" class="btn-edit">Edit</a>

                    <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Delete partner?')" class="btn-delete">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        @endforeach

    </div>

</div>

@endsection