<?php

namespace App\Http\Controllers\LandingDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Str;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('display_order')->get();
        return view('landingdashboard.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('landingdashboard.departments.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image',
            'visible' => 'boolean',
            'display_order' => 'integer'
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('departments', 'public');
        }

        Department::create($data);
        return redirect()->route('landingdashboard.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        return view('landingdashboard.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'cover_image' => 'nullable|image',
            'visible' => 'boolean',
            'display_order' => 'integer'
        ]);

        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('departments', 'public');
        }

        $department->update($data);
        return redirect()->route('landingdashboard.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('landingdashboard.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
