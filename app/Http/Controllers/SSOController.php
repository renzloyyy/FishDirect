<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Exception;

class SSOController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->stateless()->user();

            
            $user = User::where('sso_id', $socialUser->getId())
                        ->orWhere('email', $socialUser->getEmail())
                        ->first();

            if (!$user) {
                
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'sso_provider' => $provider,
                    'sso_id' => $socialUser->getId(),
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'Consumer', 
                ]);
            }

            Auth::login($user);

            
            if ($user->role === 'Consumer') {
                return redirect()->route('consumer-dashboard');
            } elseif ($user->role === 'Fisher') {
                return redirect()->route('fisherman-dashboard');
            } else {
                return redirect('/'); 
            }

        } catch (Exception $e) {
            dd($e);
            return redirect('/')->with('error', 'Failed to login: ' . $e->getMessage());
        }
    }
}
