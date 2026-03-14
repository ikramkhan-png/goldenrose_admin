<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Machinery;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MachineryController extends Controller
{
    public function index(Request $request)
    {
        $query = Machinery::query();

        // Filter by creation date month
        if ($request->filled('month')) {
            $month = Carbon::createFromFormat('Y-m', $request->month);
            $query->whereYear('created_at', $month->year)
                  ->whereMonth('created_at', $month->month);
        }

        $machineries = $query->latest()->get();
        return view('admin.machinery.index', compact('machineries'));
    }

    public function create()
    {
        return view('admin.machinery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'number_plate' => 'nullable|string|max:255',
            'hourly_rate' => 'nullable|numeric',
            'daily_rate' => 'required|numeric',
            'monthly_rate' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        Machinery::create($data);
        return redirect()->route('admin.machinery.index')->with('success','Machinery added successfully!');
    }

    public function edit(Machinery $machinery)
    {
        return view('admin.machinery.edit', compact('machinery'));
    }

    public function update(Request $request, Machinery $machinery)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'nullable|string|max:255',
            'number_plate' => 'nullable|string|max:255',
            'hourly_rate' => 'nullable|numeric',
            'daily_rate' => 'required|numeric',
            'monthly_rate' => 'nullable|numeric',
            'status' => 'required|in:active,inactive',
        ]);

        $machinery->update($data);
        return redirect()->route('admin.machinery.index')->with('success','Machinery updated successfully!');
    }

    public function destroy(Machinery $machinery)
    {
        $machinery->delete();
        return redirect()->route('admin.machinery.index')->with('success','Machinery deleted successfully!');
    }
}