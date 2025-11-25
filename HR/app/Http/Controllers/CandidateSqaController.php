<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CandidateSqa;

class CandidateSqaController extends Controller
{
    public function index()
    {
        $candidates = CandidateSqa::select([
            'user_id',
            'email',
            'name',
            'field',
            'jobrole',
            'qualification',
            'age',
            'location',
            'cnic'
        ])->get();

        return response()->json($candidates);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'email' => 'required|email',
            'name' => 'required|string',
            'field' => 'nullable|string',
            'jobrole' => 'nullable|string',
            'qualification' => 'nullable|string',
            'age' => 'nullable|integer',
            'location' => 'nullable|string',
            'cnic' => 'nullable|string',
        ]);

        $candidate = CandidateSqa::create($request->only([
            'user_id', 'email', 'name', 'field', 'jobrole', 'qualification', 'age', 'location', 'cnic'
        ]));

        return response()->json(['message' => 'Candidate added', 'data' => $candidate], 201);
    }

    public function update(Request $request, $id)
    {
        $candidate = CandidateSqa::findOrFail($id);

        $candidate->update($request->only([
            'user_id','email', 'name', 'field', 'jobrole', 'qualification', 'age', 'location', 'cnic'
        ]));

        return response()->json(['message' => 'Candidate updated', 'data' => $candidate]);
    }

    public function destroy($id)
    {
        $candidate = CandidateSqa::findOrFail($id);
        $candidate->delete();

        return response()->json(['message' => 'Candidate deleted']);
    }
}
