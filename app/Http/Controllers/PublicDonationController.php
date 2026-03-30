<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationInstruction;
use App\Models\Donation;

class PublicDonationController extends Controller
{
    // Show the public donations page
    public function index()
    {
        // Fetch instructions to display on public page
        $instructions = DonationInstruction::all();
        return view('pages.donations.index', compact('instructions'));
    }

    // Show the Give Now form
    public function showForm()
    {
        return view('pages.donations.form');
    }

    // Handle form submission
    public function submitDonation(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'email'        => 'nullable|email|max:255',
            'amount'       => 'required|numeric|min:1',
            'method'       => 'required|string|max:50',
            'message'      => 'nullable|string|max:500',
        ]);

        // Save donation to the database
        Donation::create([
            'donor_name'      => $request->name,
            'phone_number'    => $request->phone_number,
            'email'           => $request->email,
            'amount'          => $request->amount,
            'mode_of_payment' => $request->method,
            'message'         => $request->message,
        ]);

        return redirect()->route('giving.form')
                         ->with('success', 'Thank you! Your donation has been received.');
    }
}
