<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Executive;
use App\Models\ChurchCouncil;
use App\Models\HQStaff;

class PublicLeadershipController extends Controller
{
    public function index($type)
    {
        $leaders = collect(); // default empty collection
        $title = '';

        switch ($type) {
            case 'executive-committee':
                // Fetch the General Superintendent first
                $generalSuperintendent = Executive::where('position', 'General Superintendent')->first();

                // Fetch other executives excluding the General Superintendent
                $otherLeaders = Executive::where('position', '!=', 'General Superintendent')
                    ->orderBy('id')
                    ->get();

                // Merge so General Superintendent appears first
                $leaders = collect();
                if ($generalSuperintendent) {
                    $leaders->push($generalSuperintendent);
                }
                $leaders = $leaders->merge($otherLeaders);

                $title = 'Executive Committee';
                break;

            case 'church-council':
                $leaders = ChurchCouncil::orderBy('id')->get();
                $title = 'Church Council';
                break;

            case 'hq-staff':
                $leaders = HQStaff::orderBy('id')->get();
                $title = 'PAG Kenya HQ Staff';
                break;

            default:
                abort(404); // unknown type
        }

        return view('pages.leadership', [
            'leaders' => $leaders,
            'type' => $title
        ]);
    }
}
