<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TblUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TblUserController extends Controller
{

    public function login(Request $request)
    {
        $request->validate([
            'email_address' => 'required|email',
            'password' => 'required',
        ]);

        $user = TblUser::where('email_address', $request->email_address)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('ramtoken')->plainTextToken;

            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
            ]);
        } else {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }

            public function showLoginForm()
            {
                return view('auth.login');
            }


    public function createAdmin(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|string|unique:tbl_users,user_id',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:tbl_users,email_address',
            'role' => 'required|string|in:admin,superadmin',
        ]);

        $hashedPassword = Hash::make($validated['last_name']);

        $admin = new TblUser([
            'user_id' => $validated['user_id'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'middle_name' => $validated['middle_name'],
            'email_address' => $validated['email_address'],
            'password' => $hashedPassword,
            'role' => $validated['role'],
        ]);

        $admin->save();

        return response()->json(['message' => 'Admin created successfully', 'admin' => $admin], 201);
    }

    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|unique:tbl_users,user_id',
            'role' => 'required|string|max:255',
            'email_address' => 'required|email|unique:tbl_users,email_address',
            'password' => 'required|min:6',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',

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

}

