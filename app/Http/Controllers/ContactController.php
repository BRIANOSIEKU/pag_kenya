<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo;

class ContactController extends Controller
{
    public function index()
{
    $contact = ContactInfo::latest()->first(); // single record

    return view('admin.contact.index', compact('contact'));
}


    public function create()
    {
        return view('admin.contact.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'website_url' => 'nullable|url',
            'official_email' => 'nullable|email',
            'customer_care_number' => 'nullable|string|max:20',
            'general_superintendent_pa_number' => 'nullable|string|max:20',
            'postal_address' => 'nullable|string|max:255',
            'google_map_embed' => 'nullable|string',
            'working_hours' => 'nullable|string|max:100',
        ]);

        ContactInfo::create([
            'website_url' => $request->website_url,
            'official_email' => $request->official_email,
            'customer_care_number' => $request->customer_care_number,
            'general_superintendent_pa_number' => $request->general_superintendent_pa_number,
            'postal_address' => $request->postal_address,
            'google_map_embed' => $request->google_map_embed,
            'working_hours' => $request->working_hours,
        ]);

        return redirect()->route('admin.contact.index')
            ->with('success', 'Contact information created successfully.');
    }

    public function edit(ContactInfo $contact)
    {
        return view('admin.contact.edit', compact('contact'));
    }

    public function update(Request $request, ContactInfo $contact)
    {
        $request->validate([
            'website_url' => 'nullable|url',
            'official_email' => 'nullable|email',
            'customer_care_number' => 'nullable|string|max:20',
            'general_superintendent_pa_number' => 'nullable|string|max:20',
            'postal_address' => 'nullable|string|max:255',
            'google_map_embed' => 'nullable|string',
            'working_hours' => 'nullable|string|max:100',
        ]);

        $contact->update([
            'website_url' => $request->website_url,
            'official_email' => $request->official_email,
            'customer_care_number' => $request->customer_care_number,
            'general_superintendent_pa_number' => $request->general_superintendent_pa_number,
            'postal_address' => $request->postal_address,
            'google_map_embed' => $request->google_map_embed,
            'working_hours' => $request->working_hours,
        ]);

        return redirect()->route('admin.contact.index')
            ->with('success', 'Contact information updated successfully.');
    }

    public function destroy(ContactInfo $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contact.index')
            ->with('success', 'Contact information deleted successfully.');
    }
}
