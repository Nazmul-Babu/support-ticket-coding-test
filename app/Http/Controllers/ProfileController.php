<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDOException;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware('AuthCheck');
     }
    public function profile(Request $request)
    {

        $data  = array();
        $data['active_menu'] = 'Profile';
        $data['page_title'] = 'Profile';
        return view('backend.pages.profile', compact('data'));
    }

    public function profile_info_update(Request $request)
    {
        $id = Auth::id();
        $current_user = User::find($id);
        try {           
            $current_user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            return redirect()->back()->with('success', 'profile Updated Successfully');
        } catch (PDOException $e) {
            return redirect()->back()->with('error', 'Please Try Again');
        }
    }

    public function profile_password_update(Request $request)
    {
        $id = Auth::id();
        $current_user = User::find($id);
        $request->validate([
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password' => 'Enter A Password',
            'password.confirmed' => 'Password  Not Matched',
        ]);
        try {
            $current_user->update([
                'password' => bcrypt($request->password)
            ]);
            return redirect()->back()->with('success', 'Password Update Successfully');
        } catch (PDOException $e) {
            return redirect()->back()->with('error', 'Password Update Failed');
        }
    }
}
