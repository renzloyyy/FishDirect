<?php

namespace App\Services;

use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SocialAuthService
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->with(['prompt' => 'login'])->redirect();
    }

    public function callback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            $email = strtolower($socialUser->getEmail());

            
            $user = User::where(function ($query) use ($provider, $socialUser) {
                $query->where('sso_provider', $provider)
                      ->where('sso_id', $socialUser->getId());
            })->orWhere('email', $email)->first();

            if (!$user) {
                
                $user = User::create([
                    'email' => $email,
                    'password' => bcrypt(Str::random(16)), 
                    'role' => 'Consumer',
                    'sso_provider' => $provider,
                    'sso_id' => $socialUser->getId(),
                ]);
            } else {
                
                if ($user->sso_provider !== $provider || $user->sso_id !== $socialUser->getId()) {
                    $user->sso_provider = $provider;
                    $user->sso_id = $socialUser->getId();
                    $user->save();
                }
            }

            
            return $user;
        } catch (\Exception $e) {
            Log::error("SocialAuth error: " . $e->getMessage());
            throw $e;
        }
    }
}
