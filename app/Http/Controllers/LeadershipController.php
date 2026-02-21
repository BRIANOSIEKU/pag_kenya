<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\HqStaff; // ✅ ADD THIS

class LeadershipController extends Controller
{
    /**
     * Resolve model dynamically based on type
     */
    protected function getModel($type)
    {
        $models = [
            'executive' => \App\Models\Executive::class,
            'council'   => \App\Models\ChurchCouncil::class,
            'hq'        => \App\Models\HqStaff::class,
        ];

        if (!array_key_exists($type, $models)) {
            abort(404, 'Invalid leadership type.');
        }

        return $models[$type];
    }

    /**
     * Admin: Display list of leaders
     */
    public function index($type)
    {
        $model = $this->getModel($type);
        $leaders = $model::latest()->get();

        switch ($type) {
            case 'executive':
                $view = 'admin.leadership.executive_index';
                break;
            case 'council':
                $view = 'admin.leadership.council_index';
                break;
            case 'hq':
                $view = 'admin.leadership.hq_index';
                break;
        }

        return view($view, compact('leaders', 'type'));
    }

    /**
     * Admin: Show create form
     */
    public function create($type)
    {
        $this->getModel($type);

        switch ($type) {
            case 'executive':
                $view = 'admin.leadership.executive_create';
                break;
            case 'council':
                $view = 'admin.leadership.council_create';
                break;
            case 'hq':
                $view = 'admin.leadership.hq_create';
                break;
        }

        return view($view, compact('type'));
    }

    /**
     * Admin: Store new leader
     */
    public function store(Request $request, $type)
    {
        $model = $this->getModel($type);

        $request->validate([
            'full_name'         => 'required|string|max:255',
            'position'          => 'required|string|max:255',
            'photo'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'contact'           => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'brief_description' => 'nullable|string',
            'message'           => 'nullable|string',
        ]);

        $data = $request->only([
            'full_name', 'position', 'contact', 'email', 'brief_description', 'message'
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('leaders'), $photoName);
            $data['photo'] = 'leaders/' . $photoName;
        }

        $model::create($data);

        return redirect()->route('admin.leadership.index', $type)
            ->with('success', ucfirst($type) . ' added successfully.');
    }

    /**
     * Admin: Show edit form
     */
    public function edit($type, $id)
    {
        $model = $this->getModel($type);
        $leader = $model::findOrFail($id);

        switch ($type) {
            case 'executive':
                $view = 'admin.leadership.executive_edit';
                break;
            case 'council':
                $view = 'admin.leadership.council_edit';
                break;
            case 'hq':
                $view = 'admin.leadership.hq_edit';
                break;
        }

        return view($view, compact('leader', 'type'));
    }

    /**
     * Admin: Update leader
     */
    public function update(Request $request, $type, $id)
    {
        $model = $this->getModel($type);
        $leader = $model::findOrFail($id);

        $request->validate([
            'full_name'         => 'required|string|max:255',
            'position'          => 'required|string|max:255',
            'photo'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'contact'           => 'nullable|string|max:255',
            'email'             => 'nullable|email|max:255',
            'brief_description' => 'nullable|string',
            'message'           => 'nullable|string',
        ]);

        $data = $request->only([
            'full_name', 'position', 'contact', 'email', 'brief_description', 'message'
        ]);

        if ($request->hasFile('photo')) {
            if ($leader->photo && File::exists(public_path($leader->photo))) {
                File::delete(public_path($leader->photo));
            }

            $photo = $request->file('photo');
            $photoName = time() . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('leaders'), $photoName);
            $data['photo'] = 'leaders/' . $photoName;
        }

        $leader->update($data);

        return redirect()->route('admin.leadership.index', $type)
            ->with('success', ucfirst($type) . ' updated successfully.');
    }

    /**
     * Admin: Delete leader
     */
    public function destroy($type, $id)
    {
        $model = $this->getModel($type);
        $leader = $model::findOrFail($id);

        if ($leader->photo && File::exists(public_path($leader->photo))) {
            File::delete(public_path($leader->photo));
        }

        $leader->delete();

        return redirect()->route('admin.leadership.index', $type)
            ->with('success', ucfirst($type) . ' deleted successfully.');
    }

    /**
     * NEW: Dedicated Public HQ Staff Page
     */
    public function hqPublic()
    {
        $staffs = HqStaff::latest()->get();
        return view('pages.hq-staff', compact('staffs'));
    }
}
