<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Committee;

class PublicCommitteeController extends Controller
{
    /**
     * Display a single committee public page.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        // Find the committee or fail with a 404 if not found
        $committee = Committee::findOrFail($id);

        // Load relationships:
        // 1. leaders - many-to-many via committee_leader
        // 2. members - one-to-many via members table
        // 3. reports - one-to-many via committee_reports table (Latest First)
        $committee->load([
            'leaders' => function($query) {
                $query->withPivot('role', 'photo', 'contact');
            }, 
            'members', 
            'reports' => function($query) {
                $query->orderBy('report_date', 'desc');
            }
        ]);

        // Use your public file: pages/showCommitee.blade.php
        return view('pages.showCommitee', compact('committee'));
    }
}