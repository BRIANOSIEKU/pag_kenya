<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devotion;

class PublicDevotionsController extends Controller
{
    // Show all devotions (list)
    public function index()
    {
        $devotions = Devotion::orderBy('date', 'desc')->paginate(10);
        return view('pages.devotions-list', compact('devotions'));
    }

    // Show single devotion
    public function show($id)
    {
        $devotion = Devotion::findOrFail($id);
        return view('pages.devotion-show', compact('devotion'));
    }
}
