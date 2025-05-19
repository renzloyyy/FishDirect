<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginBasic extends Controller
{
  public function index()
  {
    return view('content.authentications.auth-login-basic');
  }
  public function login(Request $request)
  {
      $credentials = $request->validate([
          'email-username' => 'required|string',
          'password' => 'required|string',
      ]);

      $loginField = filter_var($credentials['email-username'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

      if (Auth::attempt([$loginField => $credentials['email-username'], 'password' => $credentials['password']], $request->remember)) {
          $request->session()->regenerate();

          $role = Auth::user()->role;

          return match ($role) {
              'Admin' => redirect()->intended('/admin/dashboard'),
              'Fisher' => redirect()->intended('/fisherman/dashboard'),
              'Consumer' => redirect()->intended('/consumer/dashboard'),
              default => redirect()->intended('/')
          };
      }

      throw ValidationException::withMessages([
          'email-username' => ['The provided credentials do not match our records.'],
      ]);
  }
  public function logout(Request $request)
  {
      // Log the user out
      Auth::logout();

      // Invalidate the session to prevent session fixation attacks
      $request->session()->invalidate();

      // Regenerate the session token to protect against CSRF attacks
      $request->session()->regenerateToken();

      // Redirect to the login page or any other desired page
      return redirect('/');
  }
}
