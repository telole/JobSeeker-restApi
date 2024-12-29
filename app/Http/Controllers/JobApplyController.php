<?php

namespace App\Http\Controllers;

use App\Models\JobApplyPosition;
use App\Models\JobApplySociety;
use App\Models\Society;
use Illuminate\Http\Request;

class JobApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $token = $request->bearerToken(); 
        $society = Society::where('login_tokens', $token)->first();

        if(!$society) {
            return response()->json([
                'Message' => 'unauthorized User'
            ], 401);
        }

        $applications = JobApplySociety::with(['jobVacancy.jobCategory', 'jobApplyPositions.position'])
        ->where('society_id', $society->id)
        ->get()
        ->map(function ($application) {
            return [
                'id' => $application->jobVacancy->id,
                'category' => [
                    'id' => $application->jobVacancy->jobCategory->id,
                    'job_category' => $application->jobVacancy->jobCategory->job_category,
                ],
                'company' => $application->jobVacancy->company,
                'address' => $application->jobVacancy->address,
                'position' => $application->jobApplyPositions->map(function ($jobApplyPosition) use ($application) {
                    return [
                        'position' => $jobApplyPosition->position->position,
                        'apply_status' => $jobApplyPosition->status,
                        'notes' => $application->notes,
                    ];
                }),
            ];
        });
    
    
    

    return response()->json(['vacancies' => $applications]);

    }

    /**
     * Store a newly created resource in storage.
     */
      public function store(Request $request)
    {
        $society = Society::where('login_tokens', $request->token)->first();

if (!$society) {
    return response()->json(['message' => 'Unauthorized user'], 401);
}

$validation = $society->validation;
if (!$validation || $validation->status !== 'accepted') {
    return response()->json([
        'message' => 'Your data validator must be accepted by validator before'
    ], 401);
}

$existingApplication = JobApplySociety::where('society_id', $society->id)
    ->where('job_vacancy_id', $request->vacancy_id)
    ->exists();

if ($existingApplication) {
    return response()->json([
        'message' => 'Application for a job can only be once'
    ], 401);
}

$jobApply = JobApplySociety::create([
    'society_id' => $society->id,
    'job_vacancy_id' => $request->vacancy_id,
    'notes' => $request->notes,
    'date' => now()
]);

JobApplyPosition::create([
    'job_apply_societies_id' => $jobApply->id,
    'position_id' => $request->position_id, 
    'society_id' => $society->id,
    'job_vacancy_id' => $request->vacancy_id,
    'date' => now(),
    'status' => 'pending'
]);

return response()->json(['message' => 'Applying for job successful']);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
