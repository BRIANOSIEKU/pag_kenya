<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\District;

class PublicOverseerController extends Controller
{
    /**
     * Show the public church districts page.
     */
    public function index()
    {
        // Get all districts ordered by name and include overseer relationship
        $districts = District::with('overseer')
            ->orderBy('name')
            ->get();

        // Return the updated districts view
        return view('pages.districts', compact('districts'));
    }
}