<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Register
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('YourApp')->accessToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    // Login with MFA Token Generation
    public function login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            // Generate a 6-digit MFA token
            $mfaToken = rand(100000, 999999);
            $user->mfa_token = $mfaToken;
            $user->save();

            // Send MFA token via email
            Mail::raw("Your MFA verification code is: $mfaToken", function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Your MFA Verification Code');
            });

            // Return response with instructions for MFA verification
            return response()->json([
                'message' => 'Login successful. Check your email for the MFA token.',
                'user' => $user,
            ]);
        }

        // If authentication fails, return unauthorized response
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Verify MFA Token and issue an access token
    public function verifyMfa(Request $request)
    {
        // Validate MFA token input
        $request->validate([
            'mfa_token' => 'required|numeric|digits:6',
        ]);
    
        // Check if the MFA token matches the one stored in the session
        if ($request->mfa_token == session('mfa_token')) {
            // Log the user in using the ID stored in the session
            Auth::loginUsingId(session('user_id'));
    
            // Clear the session data related to MFA
            session()->forget('mfa_token');
            session()->forget('user_id');
    
            // Redirect to the dashboard
            return redirect()->route('dashboard');
        }
    
        // If the MFA token is incorrect, redirect back to the MFA verification page with an error
        return redirect()->route('mfa.verify')->withErrors(['mfa_token' => 'Invalid MFA token']);
    }
    

    // Get User Info (Protected Route Example)
    public function getAllUsers(Request $request)
{
    $users = User::all(); // Fetch all users
    return response()->json($users);
}
    // Update user details
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Update fields if provided
        $user->name = $request->name ?? $user->name;
        $user->email = $request->email ?? $user->email;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
