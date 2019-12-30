<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Applicant;
use App\Employer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['role'] == 2) {
            return Validator::make($data, [
                'brand'=>'required|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|integer|max:255',
            ]);
        }

        return Validator::make($data, [
            'first_name'=>'required|max:255',
            'last_name'=>'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer|max:255',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        switch ($data['role'])
        {
            case 1:
            case 2:
                break;
            default:
                $data['role'] = 1;
        }

        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
        ]);

        switch ($data['role'])
        {
            case 1:
                Applicant::create([
                    'user_id'=>$user->id,
                    'first_name'=>$data['first_name'],
                    'last_name'=>$data['last_name'],
                ]);
                break;

            case 2:
                Employer::create([
                    'user_id'=>$user->id,
                    'brand'=>$data['brand'],
                ]);
                break;

        }

        return $user;
    }
}
