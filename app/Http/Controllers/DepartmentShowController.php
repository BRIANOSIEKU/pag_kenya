<?php
namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\OtherLeader;
use App\Models\DepartmentUpcomingEvent;

class DepartmentShowController extends Controller
{
    public function show($id)
    {
        $department = Department::findOrFail($id);

        $other_leaders = OtherLeader::where('department_id', $id)->get();

        $upcomingEvents = DepartmentUpcomingEvent::where('department_id', $id)
                            ->latest()
                            ->take(4)
                            ->get();

        return view('pages.department-show', compact(
            'department',
            'other_leaders',
            'upcomingEvents'
        ));
    }
}