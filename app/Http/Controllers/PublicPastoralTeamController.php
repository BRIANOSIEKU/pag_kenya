<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PastoralTeam;

class PublicPastoralTeamController extends Controller
{
    public function byDistrict($district)
    {
        $teams = PastoralTeam::where('district_name', $district)
                              ->orderBy('name')
                              ->get();

        return view('pages.pastoral_teams.by_district', compact('teams', 'district'));
    }
}