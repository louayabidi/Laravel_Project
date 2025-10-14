<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        Report::create([
            'reporter_id' => auth()->id(),
            'post_id' => $request->post_id ?? null,
            'comment_id' => $request->comment_id ?? null,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Report submitted successfully.');
    }
}
