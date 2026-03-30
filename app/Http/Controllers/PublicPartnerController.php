<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partner;

class PublicPartnerController extends Controller
{
    // Show public partners page (all partners)
    public function index()
    {
        $partners = Partner::latest()->get();

        // Return view from pages folder
        return view('pages.partners', compact('partners'));
    }

    // Show single partner detail
    public function show($id)
    {
        $partner = Partner::findOrFail($id);

        // Return detail view
        return view('pages.partner-detail', compact('partner'));
    }
}
