<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\DonationInstruction;
use Illuminate\Support\Facades\Storage;

class DonationController extends Controller
{
    /**
     * Display all donation instructions and donor records.
     */
    public function index()
    {
        $instructions = DonationInstruction::orderBy('id', 'desc')->get();
        $donations    = Donation::orderBy('created_at', 'desc')->paginate(20);

        return view('admin.donations.index', compact('instructions', 'donations'));
    }

    /**
     * Show form to create a new donation instruction.
     */
    public function create()
    {
        return view('admin.donations.create');
    }

    /**
     * Store a newly created donation instruction with optional image.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mode_of_payment' => 'required|string|max:50',
            'account_name'    => 'required|string|max:100',
            'account_number'  => 'required|string|max:50',
            'instruction'     => 'nullable|string',
            'message'         => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/donations', $filename);
            $validated['image'] = 'donations/' . $filename;
        }

        DonationInstruction::create($validated);

        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation instruction created successfully.');
    }

    /**
     * Show form to edit an existing donation instruction.
     */
    public function edit($id)
    {
        $instruction = DonationInstruction::findOrFail($id);
        return view('admin.donations.edit', compact('instruction'));
    }

    /**
     * Update an existing donation instruction.
     */
    public function update(Request $request, $id)
    {
        $instruction = DonationInstruction::findOrFail($id);

        $validated = $request->validate([
            'mode_of_payment' => 'required|string|max:50',
            'account_name'    => 'required|string|max:100',
            'account_number'  => 'required|string|max:50',
            'instruction'     => 'nullable|string',
            'message'         => 'nullable|string',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($instruction->image && Storage::exists('public/' . $instruction->image)) {
                Storage::delete('public/' . $instruction->image);
            }

            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/donations', $filename);
            $validated['image'] = 'donations/' . $filename;
        }

        $instruction->update($validated);

        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation instruction updated successfully.');
    }

    /**
     * Delete a donation instruction and its associated image.
     */
    public function destroy($id)
    {
        $instruction = DonationInstruction::findOrFail($id);

        // Delete image if exists
        if ($instruction->image && Storage::exists('public/' . $instruction->image)) {
            Storage::delete('public/' . $instruction->image);
        }

        $instruction->delete();

        return redirect()->route('admin.donations.index')
                         ->with('success', 'Donation instruction deleted successfully.');
    }
}
