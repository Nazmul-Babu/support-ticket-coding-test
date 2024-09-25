<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticstionController extends Controller
{
    public function registration(Request $request){
        if($request->isMethod('post')){
            $request->validate([
             'name' => 'required',
             'email' => 'required',
             'password' => 'required'
            ]);
            User::create([
                'name' =>  $request->name,
                'email' =>  $request->email,
                'password' => bcrypt($request->password),
                'roll' => 'customer',
            ]);
            return redirect()->route('login')->with('success','Registration Successfull You Can Login Now');
        }
        return view('backend.pages.registration');
    }
    public function login(Request $request){
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        if($request->isMethod('post')){
            $request->validate([
             'email' => 'required',
             'password' => 'required',
             'checkbox' => 'required'
            ]);
            $credentials = ([
                'email' =>  $request->email,
                'password' => $request->password,
            ]);
            if (Auth::attempt($credentials)) {
                    return redirect()->intended(route('dashboard'));
            }else{
                return back()->withErrors([
                    'email' => 'Credential Not Matched'
                ])->onlyInput('email');
            }
            
        }
        return view('backend.pages.login');
    }
    public function logout()
    {
        Auth::guard('web')->logout();
        return to_route('login');
    }
}
