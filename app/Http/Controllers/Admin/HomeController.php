<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;
use App\Models\HeroSlide;

class HomeController extends Controller
{

    public function index()
    {
        $setting = HomeSetting::first();
        $slides = HeroSlide::orderBy('sort_order')->get();

        return view('admin.home.index', compact('setting', 'slides'));
    }

}