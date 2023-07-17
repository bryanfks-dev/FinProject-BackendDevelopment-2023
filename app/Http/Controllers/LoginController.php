<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Cookie;

class LoginController extends Controller
{
    // Method to display login page
    public function view()
    {
        return view('login');
    }

    // Method for login logic
    public function auth(Request $request)
    {
        // Validate inputted user data
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:5|max:12'
        ]);

        // Check if user auth is success
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Get keep me logged in box
            $keep_me_logged = $request->input('keep-me-box');

            // Check if user want to keep logged in
            if ($keep_me_logged) {
                // Create cookie
                $belongs_cookie = cookie("belongs", Hash::make(Auth::user()->username), time() + (3600 * 24 * 30));
                $key_cookie = cookie("key", Hash::make(Auth::user()->id), time() + (3600 * 24 * 30));

                // Redirect user to market
                if (!Auth::user()->is_admin) return redirect('/market')->cookie($belongs_cookie)->cookie($key_cookie);
                // Redirect admin to its page
                else return redirect()->intended('/dashboard');
            } else {
                // Redirect user to market
                if (!Auth::user()->is_admin) return redirect('/market');
                // Redirect admin to its page
                else return redirect()->intended('/dashboard');
            }
        }

        // Return status when user failed login
        return back()->with('login_error', 'status:error');
    }

    // Method for logout logic
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Check if cookie exist
        if ($request->hasCookie('belongs') || $request->hasCookie('key')) {
            // Destory cookie
            $belongs_cookie = Cookie::forget('belongs');
            $key_cookie = Cookie::forget('key');

            // Redirect user back to market
            return redirect('/market')->withCookie($belongs_cookie)->withCookie($key_cookie);
        } else return redirect('/market');
    }
}
