<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $devotion = [
            'title' => 'Daily Devotion Title',
            'content' => 'Short excerpt of the daily devotion goes here...',
            'image' => asset('images/devotion-placeholder.jpg'),
            'date' => now()->format('F j, Y'),
        ];

        $departments = [
            [
                'id' => 1,
                'name' => 'Youth Ministry',
                'overview' => 'Engaging young people in faith and community.',
                'image' => asset('images/department-placeholder.jpg')
            ],
            [
                'id' => 2,
                'name' => 'Music Ministry',
                'overview' => 'Leading worship through music and praise.',
                'image' => asset('images/department-placeholder.jpg')
            ],
            [
                'id' => 3,
                'name' => 'Outreach',
                'overview' => 'Serving the community with love.',
                'image' => asset('images/department-placeholder.jpg')
            ],
        ];

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

        $news = [
            [
                'id' => 1,
                'title' => 'Annual Conference',
                'content' => 'Highlights from our annual conference.',
                'image' => asset('images/news-placeholder.jpg')
            ],
            [
                'id' => 2,
                'title' => 'Mission Trip',
                'content' => 'Our recent mission trip to the local community.',
                'image' => asset('images/news-placeholder.jpg')
            ],
            [
                'id' => 3,
                'title' => 'Charity Drive',
                'content' => 'Updates on our charity initiatives.',
                'image' => asset('images/news-placeholder.jpg')
            ],
        ];

        return view('pages.home', compact('devotion', 'departments', 'programs', 'news'));
    }
}
