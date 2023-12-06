<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use PHPOpenSourceSaver\JWTAuth\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        // dd($token);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        $user = Auth::user();
        return response()->json($token);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'department_id' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'mobile_no' => 'required',
            'address' => 'required'
        ]);
        $user = User::create([
            'name' => $request->name,
            'department_id' => $request->department_id,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile_no' => $request->mobile_no,
            'address' => $request->address,
        ]);
        $token = Auth::login($user);
        return response()->json($token);
    }

    public function getprofile(Request $request)
    {
        $user = Auth::user();
        try {
            if ($user) {
                $user_id = Auth::user()->id;
                $userData = User::where('id', $user_id)->first();
                if ($userData) {
                    return response()->json($user);
                }
            }
            return response()->json([
                'message' => 'user not found',
            ]);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
}
