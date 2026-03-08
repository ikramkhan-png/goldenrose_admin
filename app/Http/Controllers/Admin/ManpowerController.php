<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Manpower;
use Illuminate\Http\Request;

class ManpowerController extends Controller
{
    public function index()
    {
        $manpowers = Manpower::all();
        return view('admin.manpower.index', compact('manpowers'));
    }

    public function create()
    {
        return view('admin.manpower.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'hourly_rate' => 'nullable|numeric',
            'daily_rate' => 'required|numeric',
            'monthly_rate' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        Manpower::create($data);
        return redirect()->route('admin.manpower.index')->with('success', 'Manpower added successfully!');
    }

    public function edit(Manpower $manpower)
    {
        return view('admin.manpower.edit', compact('manpower'));
    }

    public function update(Request $request, Manpower $manpower)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'hourly_rate' => 'nullable|numeric',
            'daily_rate' => 'required|numeric',
            'monthly_rate' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $manpower->update($data);
        return redirect()->route('admin.manpower.index')->with('success', 'Manpower updated successfully!');
    }

    public function destroy(Manpower $manpower)
    {
        $manpower->delete();
        return redirect()->route('admin.manpower.index')->with('success', 'Manpower deleted successfully!');
    }
}