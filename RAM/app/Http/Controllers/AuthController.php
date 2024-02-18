<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $request->validate([
        'email_address' => 'required|email',
        'password' => 'required',
    ]);

    $credentials = [
        'email_address' => $request->email_address,
        'password' => $request->password,
    ];

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('authToken')->plainTextToken;

    return response()->json(['token' => $token]);
}


    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_address' => 'required|email|unique:tbl_users,email_address',
            'password' => 'required|min:6',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new TblUser();
        $user->user_id = $request->user_id;
        $user->role = $request->role;
        $user->email_address = $request->email_address;
        $user->password = Hash::make($request->password);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->middle_name = $request->middle_name;
        $user->save();

        $token = $user->createToken('ramtoken')->plainTextToken;

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token,
        ], 201);
    }
            public function showLoginForm()
            {
                return view('auth.login');
            }


}
