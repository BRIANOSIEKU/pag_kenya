@extends('layouts.admin')

@section('content')
<h1>Donations / Online Giving</h1>
<hr>

<!-- ================== Instructions Section ================== -->
<h2>Donation Instructions</h2>

<a href="{{ route('admin.donations.create') }}" 
   style="background-color:#4CAF50; color:#fff; padding:8px 15px; border-radius:6px; text-decoration:none; display:inline-block; margin-bottom:15px;">
    Add New Instruction
</a>

@if($instructions->count() > 0)
<table style="width:100%; border-collapse: collapse; margin-top:10px;">
    <thead>
        <tr style="background-color:#f4f4f4;">
            <th style="padding:10px; border:1px solid #ddd;">Mode of Payment</th>
            <th style="padding:10px; border:1px solid #ddd;">Account Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Account Number</th>
            <th style="padding:10px; border:1px solid #ddd;">Instruction</th>
            <th style="padding:10px; border:1px solid #ddd;">Message</th>
            <th style="padding:10px; border:1px solid #ddd;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($instructions as $instruction)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">{{ $instruction->mode_of_payment }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $instruction->account_name }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $instruction->account_number }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $instruction->instruction ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $instruction->message ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">
                <a href="{{ route('admin.donations.edit', $instruction->id) }}" 
                   style="color:#2196F3; margin-right:10px;">Edit</a>
                <form action="{{ route('admin.donations.destroy', $instruction->id) }}" method="POST" style="display:inline-block;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background:none; border:none; color:red; cursor:pointer;" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@else
<p>No donation instructions yet. Click "Add New Instruction" to create one.</p>
@endif

<br><hr><br>

<!-- ================== Donors Section ================== -->
<h2>Donors / Contributions</h2>

@if($donations->count() > 0)
<table style="width:100%; border-collapse: collapse; margin-top:20px;">
    <thead>
        <tr style="background-color:#f4f4f4;">
            <th style="padding:10px; border:1px solid #ddd;">Donor Name</th>
            <th style="padding:10px; border:1px solid #ddd;">Phone Number</th>
            <th style="padding:10px; border:1px solid #ddd;">Amount (Ksh)</th>
            <th style="padding:10px; border:1px solid #ddd;">Mode of Payment</th>
            <th style="padding:10px; border:1px solid #ddd;">Transaction ID</th>
            <th style="padding:10px; border:1px solid #ddd;">Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($donations as $donation)
        <tr>
            <td style="padding:10px; border:1px solid #ddd;">{{ $donation->donor_name }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $donation->phone_number ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ number_format($donation->amount, 2) }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $donation->mode_of_payment }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ $donation->transaction_id ?? '-' }}</td>
            <td style="padding:10px; border:1px solid #ddd;">{{ \Carbon\Carbon::parse($donation->created_at)->format('d M, Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div style="margin-top:20px;">
    {{ $donations->links() }}
</div>
@else
<p>No donations recorded yet.</p>
@endif

@endsection
