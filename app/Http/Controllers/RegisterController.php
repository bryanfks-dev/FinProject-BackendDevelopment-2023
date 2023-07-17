<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class RegisterController extends Controller
{
    // Method to display register page
    public function view() {
        return view('register');
    }

    // Method for registeration logic
    public function create_user(Request $request) {
        // Validate inputted user data
        $validatedData = $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:12'
        ]);

        // Hash user password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Create new user data
        User::create($validatedData);

        // Redirect user back to login page with regist_success status
        return redirect('/login')->with('regist_success', "status:success");
    }
}
