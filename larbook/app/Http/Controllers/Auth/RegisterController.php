<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // validation ; store user ; sign the user ; redirect

        // dd($request);
        // dd(func_get_args());
        echo 'lets start again';
    }
}
