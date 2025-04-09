<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }


    public function postLogin(Request $request)
    {
        $loginType = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->input('username'),
            'password' => $request->input('password'),
        ];
        if (Auth::attempt($credentials)) {
            $user = User::where($loginType, $request->input('username'))->first();
        
            if ($user && $user->role_id == '1') {
                return redirect('/admin')->with('success', 'Welcome to your Dashboard');
            } elseif ($user && $user->role_id == '2') {
                return redirect('/admin/accountant')->with('success', 'Welcome to your Dashboard');
            } elseif ($user && $user->role_id == '3') {
                return redirect('/admin/employee')->with('success', 'Welcome to your Dashboard');
            }
        }


        return redirect('login')->with('warning', 'Oops! You have entered invalid credentials');
    }

    public function logout() {
        Session::flush();
        Auth::logout();
        return Redirect::to("login")->with('success','Logout successfully');
    }
}
