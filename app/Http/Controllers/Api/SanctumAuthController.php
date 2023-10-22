<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SanctumAuthController extends Controller
{
    public function register (Request $request)
    {
        //Validated
        $validateUser = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'phone_number' => 'required|numeric',
            ]
        );

        if($validateUser->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Something Went Wrong!',
                'errors' => $validateUser->errors()
            ], 401);
        }

        $user = User::create([
            'name' => $request->post('name'),
            'email' => $request->post('email'),
            'password' => Hash::make($request->password),
            'phone_number'  => $request->post('phone_number'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User Created Successfully',
            'token' => $user->createToken('token')->plainTextToken,
        ], 201);
    }

    public function login (Request $request)
    {
        $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Your Credentials are not valid!',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if(!Auth::attempt($request->only(['email', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken('token')->plainTextToken
            ], 200);
    }

    public function logout ()
    {
        Auth::user()->tokens()->delete();

        return response()->json([
          'status' => true,
          'message' => 'User Logged Out Successfully',
        ], 200);
    }
}
