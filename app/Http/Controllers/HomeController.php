<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //Display the homepage
    public function index()
    {
        return view('home');
    }
    //Handle contact form submission
    public function contact(Request $request)
    {
        // Validate the request data
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|email|max:255',
            'email' => 'required|string|max:500',
            'comment' => 'required|string',
        ]);

        // Process the contact form submission (e.g., send an email, save to database, etc.)

        // Redirect back with a success message
        return redirect()->route('home')->with('success', 'Thank you for your message!');
    }
}
