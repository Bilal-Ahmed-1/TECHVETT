<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadResumeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'resume' => 'required|file|mimes:pdf|max:2048', // 2MB max
            'upload_id' => 'nullable|string',
            'job_role' => 'nullable|string',
        ]);

        if ($request->hasFile('resume')) {
            $fileName = time() . '_' . $request->file('resume')->getClientOriginalName();
            $path = $request->file('resume')->storeAs('resumes', $fileName, 'public');

            return response()->json(['message' => 'File uploaded', 'path' => $path], 201);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
}