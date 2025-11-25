<?php

namespace App\Http\Controllers;

use App\Models\CandidateNetworking;
use Illuminate\Http\Request;

class CandidateNetworkingController extends Controller
{
    public function index()
    {
        return response()->json(CandidateNetworking::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer',
            'email' => 'required|email',
            'name' => 'required|string',
            'field' => 'required|string',
            'jobrole' => 'required|string',
            'qualification' => 'required|string',
            'age' => 'required|integer',
            'location' => 'required|string',
            'cnic' => 'required|string',
        ]);

        $candidate = CandidateNetworking::create($validated);

        return response()->json($candidate, 201);
    }

    public function update(Request $request, $id)
    {
        $candidate = CandidateNetworking::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|integer',
            'email' => 'required|email',
            'name' => 'required|string',
            'field' => 'required|string',
            'jobrole' => 'required|string',
            'qualification' => 'required|string',
            'age' => 'required|integer',
            'location' => 'required|string',
            'cnic' => 'required|string',
        ]);

        $candidate->update($validated);

        return response()->json($candidate);
    }

    public function destroy($id)
    {
        $candidate = CandidateNetworking::findOrFail($id);
        $candidate->delete();

        return response()->json(['message' => 'Candidate deleted successfully']);
    }
}
