<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DonationInstruction;
use Illuminate\Support\Facades\Storage;

class DonationInstructionController extends Controller
{
    // Display all donation instructions
    public function index()
    {
        $instructions = DonationInstruction::latest()->get();
        return view('admin.donations.index', compact('instructions'));
    }

    // Show form to create new instruction
    public function create()
    {
        return view('admin.donations.create');
    }

    // Store new instruction
    public function store(Request $request)
    {
        $request->validate([
            'mode_of_payment' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'instruction' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('donations', 'public');
        }

        DonationInstruction::create($data);

        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation instruction added!');
    }

    // Show form to edit existing instruction
    public function edit(DonationInstruction $donation)
    {
        return view('admin.donations.edit', compact('donation'));
    }

    // Update existing instruction
    public function update(Request $request, DonationInstruction $donation)
    {
        $request->validate([
            'mode_of_payment' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'instruction' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('image');

        // If new image uploaded
        if ($request->hasFile('image')) {

            // Delete old image if exists
            if ($donation->image && Storage::disk('public')->exists($donation->image)) {
                Storage::disk('public')->delete($donation->image);
            }

            $data['image'] = $request->file('image')->store('donations', 'public');
        }

        $donation->update($data);

        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation instruction updated!');
    }

    // Delete instruction
    public function destroy(DonationInstruction $donation)
    {
        // Delete image if exists
        if ($donation->image && Storage::disk('public')->exists($donation->image)) {
            Storage::disk('public')->delete($donation->image);
        }

        $donation->delete();

        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation instruction deleted!');
    }
}
