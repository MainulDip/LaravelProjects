<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show Register From
    public function create(Request $request){
        // dd($request);
        return view('users.register');
    }
}
