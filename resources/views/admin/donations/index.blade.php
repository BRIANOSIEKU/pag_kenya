@extends('layouts.admin')

@section('content')

<style>
    .container-box {
        max-width: 1100px;
        margin: auto;
        padding: 20px;
    }

    h1, h2 {
        margin-bottom: 10px;
    }

    .btn {
        display: inline-block;
        padding: 8px 14px;
        border-radius: 6px;
        text-decoration: none;
        color: #fff;
        font-weight: bold;
        transition: 0.2s;
    }

    .btn:hover {
        opacity: 0.85;
    }

    .btn-add {
        background: #4CAF50;
        margin-bottom: 15px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background: #fff;
        border-radius: 8px;
        overflow: hidden;
        margin-top: 10px;
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    thead {
        background: #f4f4f4;
    }

    tr:hover {
        background: #fafafa;
    }

    .section {
        margin-bottom: 30px;
    }

    .actions a {
        color: #2196F3;
        margin-right: 10px;
        text-decoration: none;
        font-weight: bold;
    }

    .actions button {
        background: none;
        border: none;
        color: red;
        cursor: pointer;
        font-weight: bold;
    }

    .empty {
        padding: 10px;
        color: #777;
    }

    hr {
        margin: 25px 0;
    }

    .pagination {
        margin-top: 15px;
    }
</style>

<div class="container-box">

    <h1>Donations / Online Giving</h1>

    <hr>

    <!-- ================= Instructions ================= -->
    <div class="section">

        <h2>Donation Instructions</h2>

        <a href="{{ route('admin.donations.create') }}" class="btn btn-add">
            + Add New Instruction
        </a>

        @if($instructions->count() > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th>Mode of Payment</th>
                        <th>Account Name</th>
                        <th>Account Number</th>
                        <th>Instruction</th>
                        <th>Message</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($instructions as $instruction)
                        <tr>
                            <td>{{ $instruction->mode_of_payment }}</td>
                            <td>{{ $instruction->account_name }}</td>
                            <td>{{ $instruction->account_number }}</td>
                            <td>{{ $instruction->instruction ?? '-' }}</td>
                            <td>{{ $instruction->message ?? '-' }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.donations.edit', $instruction->id) }}">Edit</a>

                                <form action="{{ route('admin.donations.destroy', $instruction->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Are you sure?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @else
            <p class="empty">No donation instructions yet. Click "Add New Instruction" to create one.</p>
        @endif

    </div>

    <hr>

    <!-- ================= Donations ================= -->
    <div class="section">

        <h2>Donors / Contributions</h2>

        @if($donations->count() > 0)

            <table class="table">
                <thead>
                    <tr>
                        <th>Donor Name</th>
                        <th>Phone</th>
                        <th>Amount (Ksh)</th>
                        <th>Mode of Payment</th>
                        <th>Transaction ID</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($donations as $donation)
                        <tr>
                            <td>{{ $donation->donor_name }}</td>
                            <td>{{ $donation->phone_number ?? '-' }}</td>
                            <td>{{ number_format($donation->amount, 2) }}</td>
                            <td>{{ $donation->mode_of_payment }}</td>
                            <td>{{ $donation->transaction_id ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($donation->created_at)->format('d M, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="pagination">
                {{ $donations->links() }}
            </div>

        @else
            <p class="empty">No donations recorded yet.</p>
        @endif

    </div>

</div>

@endsection