<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DonationInstruction;
use App\Models\Donation;
use App\Services\MpesaService;

class PublicDonationController extends Controller
{
    // Show the public donations page
    public function index()
    {
        $instructions = DonationInstruction::all();
        return view('pages.donations.index', compact('instructions'));
    }

    // Show the Give Now form
    public function showForm()
    {
        return view('pages.donations.form');
    }

    // Handle form submission and initiate M-Pesa STK Push
    public function submitDonation(Request $request, MpesaService $mpesa)
    {
        // Validate form inputs
        $request->validate([
            'name'         => 'required|string|max:255',
            'phone_number' => 'required|string|digits:10', // expect 07XXXXXXXX
            'email'        => 'nullable|email|max:255',
            'amount'       => 'required|numeric|min:1',
            'purpose'      => 'required|string|max:255',
        ]);

        // Format phone for M-Pesa (07XXXXXXXX → 2547XXXXXXXX)
        $phone = '254' . substr($request->phone_number, -9);

        // Save donation to database with status pending
        $donation = Donation::create([
            'donor_name'      => $request->name,
            'phone_number'    => $request->phone_number,
            'email'           => $request->email,
            'amount'          => $request->amount,
            'mode_of_payment' => 'M-Pesa',
            'purpose'         => $request->purpose,
            'status'          => 'pending', // new column recommended in donations table
        ]);

        try {
            // Initiate M-Pesa STK Push
            $stkResponse = $mpesa->stkPush(
                $phone,
                $request->amount,
                $request->purpose,
                'Donation to Church'
            );

            // Save the M-Pesa response for reference
            $donation->update([
                'mpesa_response' => json_encode($stkResponse)
            ]);

            return redirect()->route('giving.form')
                             ->with('success', 'STK Push sent! Check your phone to complete payment.');

        } catch (\Exception $e) {
            // Log error and show friendly message
            \Log::error('M-Pesa STK Push failed: ' . $e->getMessage());

            return redirect()->route('giving.form')
                             ->with('error', 'Failed to initiate payment. Please try again.');
        }
    }

    // M-Pesa callback endpoint (called by Daraja)
    public function mpesaCallback(Request $request)
    {
        $data = $request->all();
        \Log::info('M-Pesa Callback:', $data);

        // Only update if ResultCode = 0 (success)
        if (isset($data['Body']['stkCallback']['ResultCode']) && $data['Body']['stkCallback']['ResultCode'] == 0) {
            $checkoutRequestID = $data['Body']['stkCallback']['CheckoutRequestID'];

            // Find donation by CheckoutRequestID stored in mpesa_response
            $donation = Donation::where('mpesa_response', 'like', "%$checkoutRequestID%")->first();

            if ($donation) {
                $donation->update([
                    'status'         => 'completed',
                    'mpesa_callback' => json_encode($data)
                ]);
            }
        }

        // Respond to M-Pesa API
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Accepted']);
    }
}