<?php

namespace App\Http\Controllers;

use App\Models\Analytic;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function index()
    {
        $analytics = Analytic::paginate(10);
        return view('alimentaire.analytics.index', compact('analytics'))->with('activePage', 'analytics');
    }

    public function create()
    {
        return view('analytics.create')->with('activePage', 'analytics');
    }

    public function store(Request $request)
    {
        $request->validate([
            'daily_calories' => 'numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
            'week_start' => 'required|date',
            'week_end' => 'required|date|after_or_equal:week_start',
        ]);

        Analytic::create(array_merge($request->all(), ['user_id' => 1])); // Static
        return redirect()->route('alimentaire.analytics.index')->with('success', 'Analytic created successfully.');
    }

    public function show(Analytic $analytic)
    {
        return view('analytics.show', compact('analytic'))->with('activePage', 'analytics');
    }

    public function edit(Analytic $analytic)
    {
        return view('analytics.edit', compact('analytic'))->with('activePage', 'analytics');
    }

    public function update(Request $request, Analytic $analytic)
    {
        $request->validate([
            'daily_calories' => 'numeric',
            'protein' => 'required|numeric',
            'carbs' => 'required|numeric',
            'fat' => 'required|numeric',
            'week_start' => 'required|date',
            'week_end' => 'required|date|after_or_equal:week_start',
        ]);

        $analytic->update($request->all());
        return redirect()->route('alimentaire.analytics.index')->with('success', 'Analytic updated successfully.');
    }

    public function destroy(Analytic $analytic)
    {
        $analytic->delete();
        return redirect()->route('alimentaire.analytics.index')->with('success', 'Analytic deleted successfully.');
    }
}