<?php

namespace App\Http\Controllers;

use App\Models\Society;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function Login(Request $request) {
        $rules =[
            'id_card_number' => 'required',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'id Card Number Or Password Incorrect',
            ], 401);
        }

        $society = Society::where('id_card_number', $request->id_card_number)->where('password', $request->password)->first();

        if(!$society) {
            return response()->json([
                'message' => 'Id Card Number Or Password Incorrect'
            ], 401);
        }

        $tokens = $society->createToken('Token')->plainTextToken;

        $society->login_tokens = $tokens;
        $society->save();

        return response()->json([
            // 'data' => $society
            'name' => $society->name,
            'born_date' => $society->born_date,
            'gender' => $society->gender,
            'address' => $society->address,
            'token' => $society->login_tokens,
            'regional' => $society->regional

        ]);

    }

    public function logout(Request $request) {

        // $user = Auth::user();

        // dd($user);
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success'
        ]);

    }
}
