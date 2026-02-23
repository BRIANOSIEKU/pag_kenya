<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Overseer;

class PublicOverseerController extends Controller
{
    /**
     * Show the public church overseers page.
     */
    public function index()
    {
        // Get all overseers ordered by name
        $overseers = Overseer::orderBy('name')->get();

        // Return a dedicated public view
        return view('pages.overseers', compact('overseers'));
    }
}