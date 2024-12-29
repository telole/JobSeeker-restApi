<?php

namespace App\Http\Controllers;

use App\Models\JobApplyPosition;
use App\Models\JobVacancy;
use App\Models\Society;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $token = $request->bearerToken();
        $society = Society::where('login_tokens', $token)->first();

        if(!$society) {
            return response()->json([
                'message' => 'Unauthorized User'
            ], 401);
        }

        $validation = $society->validation;

        if(!$validation || $validation->status !=='accepted') {
            return response()->json(['message' => 'validation required']);

        }

        $vacancies = JobVacancy::with(['jobCategory', 'AvaiblePosition'])
        ->where('job_category_id', $validation->job_category_id)->get()
        ->map(function($vacancy){
            return [
                'id' => $vacancy->id,
                'category' => [
                    'id' => $vacancy->jobCategory->id,
                    'job_category' => $vacancy->jobCategory->job_category,
                ],
                'company' => $vacancy->company,
                'address' => $vacancy->address,
                'description' => $vacancy->description,
                'available_position' => $vacancy->AvaiblePosition->map(function($position){
                    return [
                        'position' => $position->position,
                        'capacity' => $position->capacity,
                        'apply_capacity' => $position->apply_capacity,
                    ];
                })
                
            ];
        });

        return response()->json(['vacancies' => $vacancies]);





    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        //
        $token = $request->bearerToken();
        $society = Society::where('login_tokens', $token)->first();

        if(!$society) {
            return response()->json([
                'message' => 'Unauthorized User'
            ], 401);
        }

        $vacancy = JobVacancy::with('jobCategory', 'AvaiblePosition')->find($id);

        if(!$vacancy) {
            return response()->json(['message' => 'vacancies not found']);
        }

        $availableposition = $vacancy->AvaiblePosition->map(function($position){
            $applycount = JobApplyPosition::where('position_id', $position->id)->count();
            return[
                'position' => $position->position,
                'capacity' => $position->capacity,
                'apply_capacity' => $position->apply_capacity,
                'apply_count' => $applycount,
            ];
        });

        return response()->json([
            'vacancy' => [
                'id' => $vacancy->id,
                'category' => [
                    'id' => $vacancy->jobCategory->id,
                    'job_category' => $vacancy->jobCategory->job_category,
                ],
                'company' => $vacancy->company,
                'address' => $vacancy->address,
                'description' => $vacancy->description,
                'available_position' => $availableposition
            ]
            ]);
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
