<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\MFATokenMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use DB;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('login');
    }

    // Handle login logic
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check credentials
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Generate an MFA token
            $mfaToken = random_int(100000, 999999);

            // Store the token and user ID in the session
            session(['mfa_token' => $mfaToken, 'user_id' => $user->id]);

            // Send MFA token to the user's email
            Mail::to($user->email)->send(new MFATokenMail($mfaToken));

            // Redirect to the MFA verification form
            return redirect()->route('mfa.verify');
        }

        return redirect()->route('login')->withErrors(['email' => 'Invalid credentials']);
    }

    // Show the MFA verification form
    public function showMfaForm()
    {
        return view('auth.mfa_verify');
    }

    // Verify the MFA token
    public function verifyMfa(Request $request)
    {
        $request->validate([
            'mfa_token' => 'required|numeric|digits:6',
        ]);

        // Check if the MFA token matches the one stored in the session
        if ($request->mfa_token == session('mfa_token')) {
            Auth::loginUsingId(session('user_id'));

            // Clear the session data
            session()->forget('mfa_token');
            session()->forget('user_id');
            
            // $response = DB::table('customers')->get();

            // Redirect to the dashboard
            return redirect()->route('dashboard')->with('User Veryfy successfully');
            


        } else {

            return redirect()->route('mfa.verify')->withErrors(['mfa_token' => 'Invalid MFA token']);

        }

    }



    // Logout the user
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function customerList(Request $request)
    {
        // $customers = Customer::all(); // Fetch all customers
        $customers = DB::table('customers')->get();

        return view('dashboard', compact('customers')); 
    }
    
}
