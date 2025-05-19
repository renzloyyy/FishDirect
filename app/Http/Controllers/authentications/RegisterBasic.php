<?php
namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Fisher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterBasic extends Controller
{
    public function index()
    {
        return view('content.authentications.auth-register-basic');
    }
    public function fisher()
    {
      return view('content.authentications.auth-register-fisher');
    }

    public function register(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        try {
            // Create the user with the 'Consumer' role
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'Consumer', 
            ]);

            // Log the user in after successful registration
            auth()->login($user);

            // Redirect to the profile completion page
            return redirect()->route('consumer-dashboard');
        } catch (\Exception $e) {
            // Catch any exceptions and display error messages
            \Log::error('Error creating user: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was an issue creating your account. Please try again.']);
        }
    }
    public function registerFisher(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'password' => 'required|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        try {
            // Create the user with the 'Fisher' role
            $user = User::create([
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'Fisher', 
            ]);
            
            // Create basic fisher profile
            $fisher = Fisher::create([
                'user_id' => $user->id,
                'full_name' => $validated['full_name'],
                'phone' => $validated['phone'],
                'agreed_terms' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Log the user in after successful registration
            auth()->login($user);

            return redirect()->route('fisherman-dashboard');
        } catch (\Exception $e) {
            // Catch any exceptions and display error messages
            \Log::error('Error creating fisher: ' . $e->getMessage());
            return back()->withErrors(['error' => 'There was an issue creating your account. Please try again.']);
        }
    }
}
