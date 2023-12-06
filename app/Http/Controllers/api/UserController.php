<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function store(Request $request)
    {
        $emp = new User();
        $emp->name = $request->input('name');
        $emp->department_id = $request->input('department_id');
        $emp->email = $request->input('email');
        $emp->password = Hash::make($request->input('password')); // Hash the password
        $emp->mobile_no = $request->input('mobile_no');
        $emp->address = $request->input('address');
        $emp->save();

        return response()->json(['message' => 'employee added successfully'], 201);
    }
}
