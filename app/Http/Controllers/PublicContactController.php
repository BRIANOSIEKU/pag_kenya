<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactInfo; // ← Correct model

class PublicContactController extends Controller
{
    // Show the contact page
    public function index()
    {
        $contact = ContactInfo::first(); // fetch the first row
        return view('pages.contact', compact('contact'));
    }
}
