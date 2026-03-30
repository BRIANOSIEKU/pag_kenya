<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\DepartmentAchievement;
use Illuminate\Support\Facades\Storage;

class DepartmentAchievementController extends Controller
{
    /**
     * Store a new achievement for a department
     */
    public function store(Request $request, $departmentId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'nullable|date',
            'photo' => 'nullable|image|max:2048', // max 2MB
        ]);

        $department = Department::findOrFail($departmentId);

        $achievementData = $request->only(['name', 'description', 'date']);

        // Handle photo upload
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('departments_achievements', 'public');
            $achievementData['photo'] = basename($path);
        }

        $department->achievements()->create($achievementData);

        return redirect()->back()->with('success', 'Achievement added successfully.');
    }

    /**
     * Optional: Delete an achievement
     */
    public function destroy($id)
    {
        $achievement = DepartmentAchievement::findOrFail($id);

        // Delete photo file if exists
        if ($achievement->photo && Storage::disk('public')->exists('departments_achievements/'.$achievement->photo)) {
            Storage::disk('public')->delete('departments_achievements/'.$achievement->photo);
        }

        $achievement->delete();

        return redirect()->back()->with('success', 'Achievement deleted successfully.');
    }
}
