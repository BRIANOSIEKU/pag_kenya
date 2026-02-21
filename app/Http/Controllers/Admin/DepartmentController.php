<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments (Admin view).
     */
    public function index()
    {
        $departments = Department::with('documents')->orderBy('id', 'desc')->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    /**
     * Show the form for creating a new department.
     */
    public function create()
    {
        return view('admin.departments.create');
    }

    /**
     * Store a newly created department in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'overview' => 'nullable|string',
            'leadership' => 'nullable|string',
            'activities' => 'nullable|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $department = new Department($request->only([
            'name', 'overview', 'leadership', 'activities', 'description'
        ]));

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('departments_photos', 'public');
            $department->photo = basename($path);
        }

        $department->save();

        return redirect()->route('admin.departments.index')->with('success', 'Department created successfully.');
    }

    /**
     * Display the specified department (Admin view).
     */
    public function show(Department $department)
    {
        $department->load('documents');
        return view('admin.departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified department.
     */
    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    /**
     * Update the specified department in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'overview' => 'nullable|string',
            'leadership' => 'nullable|string',
            'activities' => 'nullable|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $department->fill($request->only([
            'name', 'overview', 'leadership', 'activities', 'description'
        ]));

        // Update photo if uploaded
        if ($request->hasFile('photo')) {
            if ($department->photo && Storage::disk('public')->exists('departments_photos/'.$department->photo)) {
                Storage::disk('public')->delete('departments_photos/'.$department->photo);
            }
            $path = $request->file('photo')->store('departments_photos', 'public');
            $department->photo = basename($path);
        }

        $department->save();

        return redirect()->route('admin.departments.index')->with('success', 'Department updated successfully.');
    }

    /**
     * Remove the specified department from storage.
     */
    public function destroy(Department $department)
    {
        // Delete photo if exists
        if ($department->photo && Storage::disk('public')->exists('departments_photos/'.$department->photo)) {
            Storage::disk('public')->delete('departments_photos/'.$department->photo);
        }

        // Delete all related documents
        foreach ($department->documents as $doc) {
            if (Storage::disk('public')->exists('departments_documents/'.$doc->file_path)) {
                Storage::disk('public')->delete('departments_documents/'.$doc->file_path);
            }
            $doc->delete();
        }

        $department->delete();

        return redirect()->route('admin.departments.index')->with('success', 'Department deleted successfully.');
    }

    /**
     * Upload a new document for a department.
     */
    public function uploadDocument(Request $request, Department $department)
    {
        $request->validate([
            'document' => 'required|file|max:5120',
            'name' => 'required|string|max:255',
        ]);

        $file = $request->file('document');
        $filename = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '_' . time() . '.' . $file->getClientOriginalExtension();

        $file->storeAs('departments_documents', $filename, 'public');

        $department->documents()->create([
            'name' => $request->name,
            'file_path' => $filename,
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }

    /**
     * Delete a specific document.
     */
    public function deleteDocument(DepartmentDocument $document)
    {
        if (Storage::disk('public')->exists('departments_documents/'.$document->file_path)) {
            Storage::disk('public')->delete('departments_documents/'.$document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    /**
     * Public-facing method to show a department
     */
    public function publicShow($id)
    {
        // Fetch department with achievements and documents
        $department = Department::with(['achievements', 'documents'])->findOrFail($id);

        // Return the correct public view
        return view('pages.department-show', compact('department'));
    }
}
