<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'post_id' => 'required_without:comment_id|exists:posts,id',
        'comment_id' => 'required_without:post_id|exists:comments,id',
        'reason' => 'required|string|max:255',
        'description' => 'nullable|string|max:500'
    ]);

    Report::create([
        'reporter_id' => Auth::id(),
        'post_id' => $request->post_id,
        'comment_id' => $request->comment_id,
        'reason' => $request->reason,
        'description' => $request->description,
        'status' => 'pending'
    ]);

    return back()->with('success', 'Signalement envoyé avec succès! Notre équipe va examiner votre rapport.');
}

    public function updateStatus(Request $request, Report $report)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_review,resolved,dismissed'
        ]);

        $report->update([
            'status' => $request->status,
            'assigned_to' => Auth::id() // Auto-assign to current admin when updating status
        ]);

        return back()->with('success', 'Statut du signalement mis à jour!');
    }

    public function destroy(Report $report)
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            abort(403);
        }

        $report->delete();

        return back()->with('success', 'Signalement supprimé!');
    }
}
