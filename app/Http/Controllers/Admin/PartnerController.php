<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;

class PartnerController extends Controller
{
    // ================= INDEX =================
    public function index()
    {
        $partners = Partner::latest()->get();
        return view('admin.partners.index', compact('partners'));
    }

    // ================= CREATE =================
    public function create()
    {
        return view('admin.partners.create');
    }

    // ================= STORE =================
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
        }

        Partner::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner created successfully.');
    }

    // ================= SHOW =================
    public function show(Partner $partner)
    {
        return view('admin.partners.show', compact('partner'));
    }

    // ================= EDIT =================
    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    // ================= UPDATE =================
    public function update(Request $request, Partner $partner)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('partners', 'public');
            $partner->logo = $logoPath;
        }

        $partner->name = $request->name;
        $partner->description = $request->description;
        $partner->save();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner updated successfully.');
    }

    // ================= DELETE =================
    public function destroy(Partner $partner)
    {
        $partner->delete();

        return redirect()->route('admin.partners.index')
            ->with('success', 'Partner deleted successfully.');
    }
}
