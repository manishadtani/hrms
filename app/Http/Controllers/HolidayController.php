<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Carbon\Carbon;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $query = Holiday::query();

        $year = $request->filled('year') ? $request->year : Carbon::now()->year;
        $query->whereYear('date', $year);

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $holidays = $query->orderBy('date', 'asc')->get();

        return view('admin.holidays.index', compact('holidays', 'year'));
    }

    public function create()
    {
        return view('admin.holidays.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:national,regional,company,optional',
            'description' => 'nullable|string',
        ]);

        Holiday::create([
            'name' => $request->name,
            'date' => $request->date,
            'type' => $request->type,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday added successfully!');
    }

    public function edit(Holiday $holiday)
    {
        return view('admin.holidays.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|in:national,regional,company,optional',
            'description' => 'nullable|string',
        ]);

        $holiday->update([
            'name' => $request->name,
            'date' => $request->date,
            'type' => $request->type,
            'description' => $request->description,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday updated successfully!');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('admin.holidays.index')
            ->with('success', 'Holiday deleted successfully!');
    }

    /**
     * Holiday Calendar — Public view for all roles
     */
    public function calendar(Request $request)
    {
        $year = $request->filled('year') ? $request->year : Carbon::now()->year;
        $holidays = Holiday::where('is_active', true)
            ->whereYear('date', $year)
            ->orderBy('date', 'asc')
            ->get()
            ->groupBy(function ($holiday) {
                return $holiday->date->month;
            });

        return view('holidays.calendar', compact('holidays', 'year'));
    }
}
