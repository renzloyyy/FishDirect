<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginBasic extends Controller
{
    public function index(Request $request)
    {
        $showCaptcha = RateLimiter::attempts($this->throttleKey($request)) >= 3;

        return view('content.authentications.auth-login-basic', compact('showCaptcha'));
    }

    public function login(Request $request)
    {
        $this->checkTooManyFailedAttempts($request);

        $credentials = $request->validate([
            'email-username' => 'required|string',
            'password' => 'required|string',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $loginField = filter_var($credentials['email-username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginField => $credentials['email-username'], 'password' => $credentials['password']], $request->remember)) {
            $this->clearLoginAttempts($request);

            $request->session()->regenerate();

            $role = Auth::user()->role;

            return match ($role) {
                'Admin' => redirect()->intended('/admin/dashboard'),
                'Fisher' => redirect()->intended('/fisherman/dashboard'),
                'Consumer' => redirect()->intended('/consumer/dashboard'),
                default => redirect()->intended('/')
            };
        }

        RateLimiter::hit($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email-username' => ['The provided credentials do not match our records.'],
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    private function checkTooManyFailedAttempts(Request $request)
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        throw ValidationException::withMessages([
            'email-username' => [
                "Too many login attempts. Please try again in {$seconds} seconds.",
            ],
        ]);
    }

    private function throttleKey(Request $request)
    {
        return Str::transliterate(
            Str::lower($request->input('email-username')) . '|' . $request->ip()
        );
    }

    private function clearLoginAttempts(Request $request)
    {
        RateLimiter::clear($this->throttleKey($request));
    }
}
