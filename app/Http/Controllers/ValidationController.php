<?php

namespace App\Http\Controllers;

use App\Models\Society;
use App\Models\Validation;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $token = $request->bearerToken(); 
        $society = Society::where('login_tokens', $token)->first();

        if(!$society) {
            return response()->json([
                'Message' => 'unauthorized User'
            ], 401);
        }

        $validation = Validation::create([
            'society_id' => $society->id,
            'status' => 'pending',
            'work_experience' => $request->work_experience,
            'job_category_id' => $request->job_category_id,
            'job_position' => $request->job_position,
            'request_accepted' => $request->reason_accepted,

        ]);

        return response()->json([
            'message' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $society = Society::where('login_tokens', $request->token)->first();
        if(!$society) {
            return response()->json([
                'Message' => 'unauthorized User'
            ], 401);
        }

        $validation = $society->validation()->get();

        return response()->json(['validation' => $validation]);


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
