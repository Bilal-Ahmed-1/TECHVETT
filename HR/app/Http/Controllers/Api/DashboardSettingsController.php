<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OverallCandidate;
use App\Models\TopAcceptedCandidate;
use App\Models\AcceptedRejectedCandidate;
use App\Models\UpcomingActivity;
use App\Models\MainHeadingChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DashboardSettingsController extends Controller
{
    public function save(Request $request)
    {
        try {
            $cardType = $request->input('card_type');
            $fields = $request->input('fields');

            $validator = $this->validateFields($cardType, $fields);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $modelMap = [
                'OVERALL CANDIDATES OF SQA AND NETWORKING' => OverallCandidate::class,
                'TOP NOTCH ACCEPTED CANDIDATES' => TopAcceptedCandidate::class,
                'TOTAL ACCEPTED AND REJECTED CANDIDATES' => AcceptedRejectedCandidate::class,
                'CHECK UPCOMING ACTIVITIES OF CANDIDATES' => UpcomingActivity::class,
                'DEFAULT CHANGES ON MAIN HEADING' => MainHeadingChange::class,
            ];

            if (!isset($modelMap[$cardType])) {
                return response()->json(['error' => 'Invalid card type'], 400);
            }

            $model = $modelMap[$cardType];
            $data = [];

            foreach ($fields as $field) {
                $columnName = Str::snake($field['label']);
                $value = trim($field['value']);
                if ($field['label'] === 'User ID') {
                    $data['user_id'] = is_numeric($value) ? (int)$value : $value;
                } else {
                    $data[$columnName] = $value;
                }
            }

            Log::debug('Data to be saved:', $data);
            $record = $model::create($data);

            return response()->json(['message' => 'Record saved successfully', 'data' => $record], 201);
        } catch (\Exception $e) {
            Log::error('Failed to save dashboard settings: ' . $e->getMessage(), [
                'card_type' => $request->input('card_type') ?? 'unknown',
                'fields' => $fields ?? [],
                'data' => $data ?? [],
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => config('app.debug') ? $e->getMessage() : 'Server error occurred'], 500);
        }
    }

    public function getDashboardData()
    {
        try {
            // Fetch data from respective tables
            $totalCandidates = OverallCandidate::count();
            $candidates = OverallCandidate::all()->map(function ($candidate) {
                return [
                    'total_candidate' => $candidate->total_candidate,
                    'user_id' => $candidate->user_id,
                    'field_or_job_role' => $candidate->field_or_job_role,
                    'candidate_name' => $candidate->candidate_name,
                    'date' => $candidate->date,
                    'month' => $candidate->month,
                    'year' => $candidate->year,
                ];
            });

            $acceptedCandidates = TopAcceptedCandidate::all()->map(function ($candidate) {
                return [
                    'name' => $candidate->candidate_name,
                    'percentage' => $candidate->aggregate_of_stages ?? rand(70, 90), // Use actual percentage if available
                ];
            })->take(3);

            $upcomingActivities = UpcomingActivity::where('time', '>=', now())->get()->map(function ($activity) {
                return [
                    'candidate_id' => $activity->user_id,
                    'name' => $activity->meeting_with_candidate_name,
                    'time' => $activity->time,
                    'status' => $activity->condition_of_meeting ?? ($activity->time->isToday() ? 'Due Soon' : 'Pending'),
                ];
            })->take(3);

            $reportData = AcceptedRejectedCandidate::all()->groupBy('progress')->map(function ($group) {
                return $group->count();
            })->all();
            $acceptedCount = $reportData['Accepted'] ?? 0;
            $rejectedCount = $reportData['Rejected'] ?? 0;
            $pendingCount = $totalCandidates - ($acceptedCount + $rejectedCount);

            $mainHeading = MainHeadingChange::first() ?? ['title' => 'Welcome Back, Human Resourcement', 'quotation' => 'You have 20 new candidates added to your dashboard. Please review and evaluate the latest updates.'];

            return response()->json([
                'total_candidates' => $totalCandidates,
                'new_candidates' => $candidates->where('date', '>=', now()->subDays(7))->count(), // Last 7 days as new
                'accepted' => $acceptedCandidates,
                'activities' => $upcomingActivities,
                'report' => [
                    'accepted' => $acceptedCount,
                    'rejected' => $rejectedCount,
                    'pending' => $pendingCount,
                ],
                'stages' => [
                    ['name' => 'Stage 1: MCQs', 'icon' => 'fa-question-circle'],
                    ['name' => 'Stage 2: Image Analysis', 'icon' => 'fa-image'],
                    ['name' => 'Stage 3: Voice Interview', 'icon' => 'fa-microphone'],
                ],
                'main_heading' => $mainHeading,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Failed to fetch dashboard data: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }
    }

    protected function validateFields($cardType, $fields)
    {
        $rules = [];
        switch ($cardType) {
            case 'OVERALL CANDIDATES OF SQA AND NETWORKING':
                $rules = $this->getRulesForOverallCandidates($fields);
                break;
            case 'TOP NOTCH ACCEPTED CANDIDATES':
                $rules = $this->getRulesForTopAcceptedCandidates($fields);
                break;
            case 'TOTAL ACCEPTED AND REJECTED CANDIDATES':
                $rules = $this->getRulesForAcceptedRejectedCandidates($fields);
                break;
            case 'CHECK UPCOMING ACTIVITIES OF CANDIDATES':
                $rules = $this->getRulesForUpcomingActivities($fields);
                break;
            case 'DEFAULT CHANGES ON MAIN HEADING':
                $rules = $this->getRulesForMainHeadingChanges($fields);
                break;
        }

        return Validator::make($fields, $rules, [
            '*.label.required' => 'The field label is required.',
            '*.value.required' => 'The :attribute value is required.',
            '*.value.date' => 'The :attribute must be a valid date in YYYY-MM-DD format.',
            '*.value.regex' => 'The :attribute format is invalid.',
            '*.value.in' => 'The :attribute must be one of the allowed values.',
        ]);
    }

    protected function getRulesForOverallCandidates($fields)
    {
        $rules = [];
        foreach ($fields as $index => $field) {
            $rules["$index.label"] = 'required|string';
            if ($field['label'] === 'Date') {
                $rules["$index.value"] = ['required', 'date', 'regex:/^\d{4}-\d{2}-\d{2}$/'];
            } elseif ($field['label'] === 'User ID') {
                $rules["$index.value"] = ['required', 'numeric'];
            } elseif ($field['label'] === 'Year') {
                $rules["$index.value"] = ['required', 'regex:/^\d{4}$/'];
            } else {
                $rules["$index.value"] = 'required|string';
            }
        }
        return $rules;
    }

    protected function getRulesForTopAcceptedCandidates($fields)
    {
        $rules = [];
        foreach ($fields as $index => $field) {
            $rules["$index.label"] = 'required|string';
            if ($field['label'] === 'User ID') {
                $rules["$index.value"] = ['required', 'numeric'];
            } elseif ($field['label'] === 'Aggregate of Stages') {
                $rules["$index.value"] = ['required', 'numeric'];
            } else {
                $rules["$index.value"] = 'required|string';
            }
        }
        return $rules;
    }

    protected function getRulesForAcceptedRejectedCandidates($fields)
    {
        $rules = [];
        foreach ($fields as $index => $field) {
            $rules["$index.label"] = 'required|string';
            if ($field['label'] === 'Progress') {
                $rules["$index.value"] = 'required|in:Accepted,Rejected';
            } elseif ($field['label'] === 'User ID') {
                $rules["$index.value"] = ['required', 'numeric'];
            } elseif ($field['label'] === 'Year') {
                $rules["$index.value"] = ['required', 'regex:/^\d{4}$/'];
            } else {
                $rules["$index.value"] = 'required|string';
            }
        }
        return $rules;
    }

    protected function getRulesForUpcomingActivities($fields)
    {
        $rules = [];
        foreach ($fields as $index => $field) {
            $rules["$index.label"] = 'required|string';
            if ($field['label'] === 'Time') {
                $rules["$index.value"] = ['required', 'regex:/^\d{2}:\d{2}(:\d{2})?$/'];
            } elseif ($field['label'] === 'Online meeting/Offline Meeting') {
                $rules["$index.value"] = 'required|in:Online,Offline';
            } elseif ($field['label'] === 'Condition of Meeting') {
                $rules["$index.value"] = 'required|in:Scheduled,Postponed,Completed';
            } elseif ($field['label'] === 'User ID') {
                $rules["$index.value"] = ['required', 'numeric'];
            } else {
                $rules["$index.value"] = 'required|string';
            }
        }
        return $rules;
    }

    protected function getRulesForMainHeadingChanges($fields)
    {
        $rules = [];
        foreach ($fields as $index => $field) {
            $rules["$index.label"] = 'required|string';
            $rules["$index.value"] = 'required|string';
        }
        return $rules;
    }
}