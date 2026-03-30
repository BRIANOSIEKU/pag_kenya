<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Devotion;
use App\Models\Department;
use App\Models\ContactInfo;
use App\Models\LiveStream;
use App\Models\Announcement;

// ✅ Add these based on admin tables
use App\Models\HeroSlide;
use App\Models\HomeSetting;

class HomeController extends Controller
{
    public function index()
    {
        // --- HERO SLIDES (multiple scrolling images) ---
        $heroSlides = HeroSlide::where('is_active', 1)
                               ->orderBy('sort_order', 'asc')
                               ->get();

        // --- THEME AND SCRIPTURE OF THE YEAR ---
        $homeSetting = HomeSetting::first();

        // --- Fetch latest 4 news items ---
        $news = News::with('photos')
                    ->orderBy('created_at', 'desc')
                    ->take(4)
                    ->get();

        // --- Fetch latest 4 devotions ---
        $devotions = Devotion::orderBy('date', 'desc')
                             ->take(4)
                             ->get();

        // --- Fetch all departments ---
        $departments = Department::all();

        // --- Fetch latest Contact Info ---
        $contactInfo = ContactInfo::latest()->first();

        // --- Fetch Active Livestream ---
        $liveStream = LiveStream::where('is_active', 1)
                                ->latest()
                                ->first();

        // --- Fetch latest 6 announcements ---
        $announcements = Announcement::orderBy('created_at', 'desc')
                                     ->take(6)
                                     ->get();

        // --- Programs Section ---
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

        // --- Pass all variables to homepage ---
        return view('pages.home', compact(
            'heroSlides',    // ✅ Active hero slides
            'homeSetting',   // ✅ Theme & Scripture
            'devotions',
            'departments',
            'programs',
            'news',
            'contactInfo',
            'liveStream',
            'announcements'
        ));
    }
}