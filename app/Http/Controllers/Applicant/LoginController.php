<?php

namespace App\Http\Controllers\applicant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index() {
        return view('applicant.settings.login', ['user'=>Auth::user()]);
    }

    public function email(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255'
        ]);

        $user = Auth::user();

        if ($request->email !== $user->email) {
            $request->validate([
                'email' => 'unique:users'
            ]);

            $user->email = $request->email;
            $user->save();
        }

        return redirect()->back()->with('success', 'E-Mail Address был обновлен');
    }

    public function password(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = Auth::user();

        $valid_password = Auth::validate([
            'email'=>$user->email,
            'password'=>$request->password
        ]);

        if ($valid_password) {
            $user->password = Hash::make($request->new_password);

            $user->save();
        } else {
            return redirect()->back()->with('success', 'Текущий пароль не верен');
        }

        return redirect()->back()->with('success', 'Текущий пароль был обновлен');
    }
}
