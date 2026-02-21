<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Devotion;
use App\Models\Department;
use App\Models\ContactInfo; // ✅ Add this

class HomeController extends Controller
{
    public function index()
    {
        // --- Fetch latest 4 news items for homepage ---
        $news = News::with('photos')->orderBy('created_at', 'desc')->take(4)->get();

        // --- Fetch latest 4 devotions for Featured Devotions section ---
        $devotions = Devotion::orderBy('date', 'desc')->take(4)->get();

        // --- Fetch all departments (use leadership column directly) ---
        $departments = Department::all();

        // --- Fetch latest Contact Info for Contact Us section ---
        $contactInfo = ContactInfo::latest()->first(); // ✅ Added

        // --- Programs Section (static placeholder) ---
        $programs = [
            [
                'title' => 'Sunday School',
                'description' => 'Fun and faith for kids.',
                'image' => asset('images/program-placeholder.jpg')
            ],
            [
                'title' => 'Bible Study',
                'description' => 'Deep dive into God\'s Word.',
                'image' => asset('images/program-placeholder.jpg')
            ],
            [
                'title' => 'Community Service',
                'description' => 'Helping those in need.',
                'image' => asset('images/program-placeholder.jpg')
            ],
        ];

        // --- Pass all variables to the homepage view ---
        return view('pages.home', compact('devotions', 'departments', 'programs', 'news', 'contactInfo'));
    }
}
