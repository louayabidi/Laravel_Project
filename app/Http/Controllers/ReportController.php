<?php


namespace App\Http\Controllers;


use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
public function __construct()
{
$this->middleware('auth');
}


public function store(Request $request)
{
$request->validate([
'post_id' => 'nullable|exists:posts,id',
'comment_id' => 'nullable|exists:comments,id',
'reason' => 'required|string|max:2000'
]);


if (!$request->post_id && !$request->comment_id) {
return back()->withErrors('Select a post or a comment to report.');
}


$exists = Report::where('reporter_id', Auth::id())
->when($request->post_id, fn($q) => $q->where('post_id', $request->post_id))
->when($request->comment_id, fn($q) => $q->where('comment_id', $request->comment_id))
->whereIn('status', ['open','in_review'])
->exists();


if ($exists) {
return back()->with('info','You already reported this item.');
}


Report::create([
'reporter_id' => Auth::id(),
'post_id' => $request->post_id,
'comment_id' => $request->comment_id,
'reason' => $request->reason,
'status' => 'open'
]);


return back()->with('success','Report submitted');
}
}