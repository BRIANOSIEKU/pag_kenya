<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\News;
use App\Models\Devotion;
use App\Models\Department;
use App\Models\ContactInfo;
use App\Models\LiveStream;
use App\Models\Announcement;

// ✅ FIXED MODEL NAME
use App\Models\DepartmentUpcomingEvent;

use App\Models\HeroSlide;
use App\Models\HomeSetting;

class HomeController extends Controller
{
    public function index()
    {
        // --- HERO SLIDES ---
        $heroSlides = HeroSlide::where('is_active', 1)
            ->orderBy('sort_order', 'asc')
            ->get();

        // --- HOME SETTINGS ---
        $homeSetting = HomeSetting::first();

        // --- NEWS ---
        $news = News::with('photos')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // --- DEVOTIONS ---
        $devotions = Devotion::orderBy('date', 'desc')
            ->take(4)
            ->get();

        // --- DEPARTMENTS ---
        $departments = Department::all();

        // --- CONTACT ---
        $contactInfo = ContactInfo::latest()->first();

        // --- LIVE STREAM ---
        $liveStream = LiveStream::where('is_active', 1)
            ->latest()
            ->first();

        // --- ANNOUNCEMENTS ---
        $announcements = Announcement::orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // --- UPCOMING EVENTS (FIXED) ---
        $upcomingEvents = DepartmentUpcomingEvent::with('department')
            ->where('event_date', '>=', now())
            ->orderBy('event_date', 'asc')
            ->take(9)
            ->get();

        // --- PROGRAMS ---
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

        return view('pages.home', compact(
            'heroSlides',
            'homeSetting',
            'devotions',
            'departments',
            'programs',
            'news',
            'contactInfo',
            'liveStream',
            'announcements',
            'upcomingEvents'
        ));
    }
}