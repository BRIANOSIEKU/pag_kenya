<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\DepartmentDocument;
use App\Models\DepartmentGallery;
use App\Models\OtherLeader;
use App\Models\DepartmentUpcomingEvent;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DepartmentController extends Controller
{
    /**
     * ================= ADMIN =================
     */

    public function index()
    {
        $departments = Department::with('documents')
            ->latest()
            ->paginate(10);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'overview' => 'nullable|string',
            'leadership' => 'nullable|string',
            'activities' => 'nullable|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $department = new Department($request->only([
            'name', 'overview', 'leadership', 'activities', 'description'
        ]));

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('departments_photos', 'public');
            $department->photo = basename($path);
        }

        $department->save();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load([
            'documents',
            'galleryImages',
            'otherLeaders',
            'upcomingEvents'
        ]);

        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'overview' => 'nullable|string',
            'leadership' => 'nullable|string',
            'activities' => 'nullable|string',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $department->fill($request->only([
            'name', 'overview', 'leadership', 'activities', 'description'
        ]));

        if ($request->hasFile('photo')) {

            if (
                $department->photo &&
                Storage::disk('public')->exists('departments_photos/' . $department->photo)
            ) {
                Storage::disk('public')->delete('departments_photos/' . $department->photo);
            }

            $path = $request->file('photo')->store('departments_photos', 'public');
            $department->photo = basename($path);
        }

        $department->save();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        if (
            $department->photo &&
            Storage::disk('public')->exists('departments_photos/' . $department->photo)
        ) {
            Storage::disk('public')->delete('departments_photos/' . $department->photo);
        }

        foreach ($department->documents as $doc) {
            if (Storage::disk('public')->exists('departments_documents/' . $doc->file_path)) {
                Storage::disk('public')->delete('departments_documents/' . $doc->file_path);
            }
            $doc->delete();
        }

        foreach ($department->galleryImages as $img) {
            if (Storage::disk('public')->exists('departments_gallery/' . $img->image_path)) {
                Storage::disk('public')->delete('departments_gallery/' . $img->image_path);
            }
            $img->delete();
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }

    /**
     * ================= DOCUMENTS =================
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

    public function deleteDocument(DepartmentDocument $document)
    {
        if (Storage::disk('public')->exists('departments_documents/' . $document->file_path)) {
            Storage::disk('public')->delete('departments_documents/' . $document->file_path);
        }

        $document->delete();

        return back()->with('success', 'Document deleted successfully.');
    }

    /**
     * ================= PUBLIC PAGE (FIXED) =================
     */

    public function publicShow(Department $department)
    {
        $department->load([
            'achievements',
            'documents',
            'galleryImages',
            'otherLeaders',
            'upcomingEvents' => function ($query) {
                $query->whereDate('event_date', '>=', Carbon::today())
                    ->orderBy('event_date', 'asc')
                    ->take(5);
            }
        ]);

        return view('pages.department-show', compact('department'));
    }

    /**
     * ================= GALLERY =================
     */

    public function gallery(Department $department)
    {
        $images = $department->galleryImages;
        return view('admin.departments.gallery', compact('department', 'images'));
    }

    public function uploadGallery(Request $request, Department $department)
    {
        $request->validate([
            'image' => 'required|image|max:2048'
        ]);

        $file = $request->file('image');

        $filename = time() . '_' .
            Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
            . '.' . $file->getClientOriginalExtension();

        $file->storeAs('departments_gallery', $filename, 'public');

        $department->galleryImages()->create([
            'image_path' => $filename
        ]);

        return redirect()->route('admin.departments.gallery', $department->id)
            ->with('success', 'Image uploaded successfully.');
    }

    public function deleteGallery($imageId)
    {
        $image = DepartmentGallery::findOrFail($imageId);

        if (Storage::disk('public')->exists('departments_gallery/' . $image->image_path)) {
            Storage::disk('public')->delete('departments_gallery/' . $image->image_path);
        }

        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }
}