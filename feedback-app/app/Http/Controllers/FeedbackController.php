<?php

namespace App\Http\Controllers;
use App\Models\Feedback;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index() {
        return view('feedback');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'mood' => 'required|string',
        'rating' => 'required|integer|min:1|max:5',
        'features' => 'nullable|array',
        'comment' => 'nullable|string',
    ]);

    Feedback::create([
        'mood' => $validated['mood'],
        'rating' => $validated['rating'],
        'features' => $validated['features'] ?? [],
        'comment' => $validated['comment'] ?? null,
    ]);

    return back()->with('success', 'Thanks for your feedback!');
}
}
