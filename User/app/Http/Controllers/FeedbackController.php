<?php

namespace App\Http\Controllers;
use App\Models\Feedback;

use Illuminate\Http\Request;

class FeedbackController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mood' => 'required|in:satisfied,good,neutral,bad,unsatisfied',
            'rating' => 'required|integer|min:1|max:5',
            'features' => 'nullable|array',
            'features.*' => 'string',
            'comment' => 'nullable|string|max:1000',
        ]);

        Feedback::create([
            'mood' => $validated['mood'],
            'rating' => $validated['rating'],
            'features' => $validated['features'] ? json_encode($validated['features']) : null,
            'comment' => $validated['comment'],
        ]);

        return response()->json(['message' => 'Thank you for your feedback!']);
    }
}
