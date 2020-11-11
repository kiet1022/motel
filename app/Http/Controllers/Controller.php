<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getLogin() {
        return view('pages.login');
    }

    public function login(Request $re) {
        // Check if remember me is checked
        $remember = $re->has('remember') ? true: false;
        $login = $re->only('email','password');

        if(Auth::attempt($login,$remember)){
            return redirect()->route('get_dashboard');
        }else{
            return redirect()->back()->with('error','Email hoặc mật khẩu không đúng');
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->back();
    }
}
