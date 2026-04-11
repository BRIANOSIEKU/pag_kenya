<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Committee;
use App\Models\CommitteeDuty;
use App\Models\CommitteeMember;
use App\Models\CommitteeReport;

class CommitteeController extends Controller
{
    public function index()
    {
        $committees = Committee::with(['duties','members','reports'])->get();
        return view('admin.standing_committees.index', compact('committees'));
    }

    public function create()
    {
        return view('admin.standing_committees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'chairperson_id' => 'required|integer',
            'chairperson_name' => 'required|string|max:255',
            'chairperson_gender' => 'required|in:Male,Female,Other',
            'chairperson_photo' => 'nullable|image',
            'secretary_id' => 'required|integer',
            'secretary_name' => 'required|string|max:255',
            'secretary_gender' => 'required|in:Male,Female,Other',
            'secretary_photo' => 'nullable|image',
        ]);

        $chairPhotoPath = $request->file('chairperson_photo') ? $request->file('chairperson_photo')->store('committee_photos','public') : null;
        $secretaryPhotoPath = $request->file('secretary_photo') ? $request->file('secretary_photo')->store('committee_photos','public') : null;

        $committee = Committee::create([
            'name' => $request->name,
            'overview' => $request->overview,
            'chairperson_id' => $request->chairperson_id,
            'chairperson_name' => $request->chairperson_name,
            'chairperson_gender' => $request->chairperson_gender,
            'chairperson_photo' => $chairPhotoPath,
            'secretary_id' => $request->secretary_id,
            'secretary_name' => $request->secretary_name,
            'secretary_gender' => $request->secretary_gender,
            'secretary_photo' => $secretaryPhotoPath,
        ]);

        if($request->duties){
            foreach($request->duties as $duty){
                CommitteeDuty::create([
                    'committee_id' => $committee->id,
                    'duty' => $duty
                ]);
            }
        }

        if($request->members){
            foreach($request->members as $member){
                CommitteeMember::create([
                    'committee_id' => $committee->id,
                    'member_id' => $member['id'],
                    'member_name' => $member['name'],
                    'member_gender' => $member['gender']
                ]);
            }
        }

        if($request->reports){
            foreach($request->reports as $report){
                CommitteeReport::create([
                    'committee_id' => $committee->id,
                    'title' => $report['title'],
                    'attachment' => $report['attachment'] ?? null,
                    'report_date' => $report['date'] ?? null,
                    'description' => $report['description'] ?? null
                ]);
            }
        }

        return redirect()->route('admin.standing-committees.index')->with('success','Committee created successfully');
    }

    public function edit(Committee $standingCommittee)
    {
        return view('admin.standing_committees.edit', compact('standingCommittee'));
    }

    public function update(Request $request, Committee $standingCommittee)
    {
        // Add similar validation and update logic as store()
    }

    public function destroy(Committee $standingCommittee)
    {
        $standingCommittee->delete();
        return redirect()->route('admin.standing-committees.index')->with('success','Committee deleted');
    }
}