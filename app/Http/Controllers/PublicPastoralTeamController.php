<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PastoralTeam;
use App\Models\District;

class PublicPastoralTeamController extends Controller
{
    public function byDistrict($id)
    {
        // Get district first
        $district = District::findOrFail($id);

        // Fetch ONLY approved pastoral teams
        $teams = PastoralTeam::with('assembly')
            ->where('district_id', $district->id)
            ->where('status', 'approved') // 👈 ONLY APPROVED
            ->orderBy('name', 'asc')
            ->get();

        return view('pages.pastoral_teams.by_district', compact('teams', 'district'));
    }
}