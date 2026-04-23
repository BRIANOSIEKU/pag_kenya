<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentUpcomingEvent;
use Illuminate\Support\Facades\Storage;

class DepartmentUpcomingEventController extends Controller
{
    public function index($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        $events = DepartmentUpcomingEvent::where('department_id', $departmentId)
            ->latest()
            ->paginate(10);

        return view('admin.departments.upcoming_events.index', compact('department', 'events'));
    }

    public function create($departmentId)
    {
        $department = Department::findOrFail($departmentId);

        return view('admin.departments.upcoming_events.create', compact('department'));
    }

    public function store(Request $request, $departmentId)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            $data['file'] = $request->file('file')->store('department_events', 'public');
        }

        $data['department_id'] = $departmentId;

        DepartmentUpcomingEvent::create($data);

        return redirect()
            ->route('admin.departments.department_upcoming_events.index', $departmentId)
            ->with('success', 'Event created successfully.');
    }

    public function edit($departmentId, $id)
    {
        $department = Department::findOrFail($departmentId);

        $event = DepartmentUpcomingEvent::where('department_id', $departmentId)
            ->findOrFail($id);

        return view('admin.departments.upcoming_events.edit', compact('department', 'event'));
    }

    public function update(Request $request, $departmentId, $id)
    {
        $event = DepartmentUpcomingEvent::where('department_id', $departmentId)
            ->findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'event_date' => 'required|date',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);

        if ($request->hasFile('file')) {
            if ($event->file) {
                Storage::disk('public')->delete($event->file);
            }
            $data['file'] = $request->file('file')->store('department_events', 'public');
        }

        $event->update($data);

        return redirect()
            ->route('admin.departments.department_upcoming_events.index', $departmentId)
            ->with('success', 'Event updated successfully.');
    }

    public function destroy($departmentId, $id)
    {
        $event = DepartmentUpcomingEvent::where('department_id', $departmentId)
            ->findOrFail($id);

        if ($event->file) {
            Storage::disk('public')->delete($event->file);
        }

        $event->delete();

        return back()->with('success', 'Event deleted successfully.');
    }
}