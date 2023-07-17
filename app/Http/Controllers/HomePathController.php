<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomePathController extends Controller
{
    // Method to display relative page to other url
    public function view() {
        // Check if user already logged in
        if (Auth::user() != null && Auth::user()->is_admin) {
            return route('dashboard');
        }
        else return route('market');
    }
}
