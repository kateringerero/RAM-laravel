<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TblUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class TblUserController extends Controller
{

    // login backend
    public function login(Request $request)
        {
            $request->validate([
                'email_address' => 'required|email',
                'password' => 'required',
            ]);

            $user = TblUser::where('email_address', $request->email_address)->first();

            if ($user && Hash::check($request->password, $user->password)) {
                if (!$user->is_active) {
                    return response()->json(['message' => 'Your account is inactive. Please contact support.'], 403);
                }
                $token = $user->createToken('ramtoken')->plainTextToken;

                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token,
                ]);
            } else {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
        }

    // after login backend, check for role to redirect based on role
    protected function redirectBasedOnRole($role)
        {
            switch ($role) {
                case 'superadmin':
                    return redirect()->route('superadmin');
                case 'admin':
                    return redirect()->route('admin');
                case 'user':
                    return redirect()->route('user');
                default:
                    return redirect('/');
            }
        }

            public function showLoginForm()
                {
                    return view('auth.login');
                }

    // create admin - backend
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

            // return response()->json(['message' => 'Admin created successfully', 'admin' => $admin], 201);
            return redirect()->route('manage_admins.index')->with('success', 'Admin created successfully.');
        }

        // view for list of admins
        public function showAdmins()
            {
                $admins = TblUser::where(function ($query) {
                    $query->where('role', 'admin')
                        ->orWhere('role', 'superadmin');
                })->where('is_active', true)
                ->get();

                return view('manage_admins.index', ['admins' => $admins]);
            }

            // disable admins
            public function disableAdmin($user_id)
                {
                    $admin = TblUser::where('user_id', $user_id)->firstOrFail();
                    $admin->is_active = false;
                    $admin->save();

                    if (request()->wantsJson()) {
                        return response()->json(['message' => 'Admin access removed successfully.']);
                    } else {
                        return redirect()->route('manage_admins.index')->with('success', 'Admin access removed successfully.');
                    }
                }

    // create user
    public function createUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|unique:tbl_users,user_id',
            'role' => 'required|string|max:255',
            'email_address' => 'required|email|unique:tbl_users,email_address',
            'password' => 'required|max:255',
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

    // for my account
    public function currentUserDetails()
        {
            $user = Auth::user();

            return response()->json(['user' => $user], 200);
        }

    // for update password
    public function updatePassword(Request $request)
        {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            $user = Auth::user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['message' => 'Current password is incorrect.'], 401);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            // return response()->json(['message' => 'Password updated successfully.']);
            return redirect()->back()->with('success', 'Password updated successfully.');
        }

    // android
    public function loginAndroid(Request $request)
            {
                $request->validate([
                    'user_id' => 'required|string',
                    'password' => 'required',
                ]);

                $user = TblUser::where('user_id', $request->user_id)->first();

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



        public function showInfo_Android(Request $request)
            {
                $user = TblUser::select('first_name', 'last_name', 'email_address')
                            ->where('user_id', $request->user_id)
                            ->first();

                if (!$user) {
                    return response()->json(['error' => 'User not found'], 404);
                }

                return response()->json($user);
            }

}

