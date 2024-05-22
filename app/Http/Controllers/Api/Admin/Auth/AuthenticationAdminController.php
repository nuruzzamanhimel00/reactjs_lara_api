<?php

namespace App\Http\Controllers\Api\Admin\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthenticationAdminController extends Controller
{
    public function login(Request $request) {


        $request->validate([
            'email'=>'required|string|email',
            'password'=>'required|min:8'
        ]);
        try {
            $user = User::where('email',$request->email)->first();

            if(!$user || !Hash::check($request->password,$user->password)){
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid Credentials'
                ]);
            }

            $token =  $user->createToken('MyApp')->plainTextToken;

            return response()->json([
                'status' => true,
                "token" => $token,
                "user" => $user,
                "message" => 'Login successfully',
            ]);

        } catch (\Exception $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ]);
        }



    }
}
