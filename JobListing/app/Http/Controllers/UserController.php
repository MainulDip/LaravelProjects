<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // Show Register From
    public function create(Request $request){
        // dd($request);
        return view('users.register');
    }

    // Store new user
    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        // Hash Password
        $formFields['password'] = bcrypt($formFields['password']);

        
        // Create User
        $user = User::create($formFields);

        // Login
        auth()->login($user);

        return redirect('/')->with('message', 'User Created and logged in');
    }


    // Logout
    public function logout(User $user, Request $request){
        // auth()->logout();
        auth()->logout($user);

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect('/')->with('message', 'User Logged Out');
    }

    // Login User
    public function login(){
        return view('users.login');
    }

    // Authentication for login
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        // if credentials matches, it will start the session and return true
        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message', 'You\'re logged in');
        }

        return back()->withErrors(['email'=>'Invalid'])->onlyInput('email');
    }
}
