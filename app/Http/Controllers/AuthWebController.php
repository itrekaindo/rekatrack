<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthWebController extends Controller
{
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role && $user->role->name === 'Super Admin') {
                return redirect()->route('users.index');
            } elseif ($user->role && $user->role->name === 'Admin') {
                return redirect()->route('shippings.index');
            }

            Auth::logout();
            return redirect()->route('login')->with('error', 'Role tidak dikenali.');
        }

        return redirect()->back()->with('error', 'Email atau password salah.');
    }



    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
