<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectPublicController extends Controller
{
    /**
     * Show list of all projects (name + photo)
     */
    public function index()
    {
        $projects = Project::orderBy('created_at', 'desc')->get();
        return view('pages.projects', compact('projects')); // <-- updated to pages.projects
    }

    /**
     * Show full details for a single project
     */
    public function show(Project $project)
    {
        return view('pages.project-details', compact('project')); // <-- updated to pages.project-details
    }
}
