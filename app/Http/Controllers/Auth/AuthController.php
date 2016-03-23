<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    protected $username = 'username';

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    // public function authenticate()
    // {
    //     dd("fsdfsdf");
    //     if (Auth::attempt(['username' => $username, 'password' => $password, 'isApproved' => true])) {
    //         // Authentication passed...
    //         return redirect()->intended();
    //     }
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)               //Validator for creation of company
    {
        $customNames = array(
            'regcompusername' => 'username',
            'regcomppassword' => 'password',
            'regcompname' => 'name',
            'regcompemail' => 'email',
        );
        return Validator::make($data, [
            'company_name' => 'required|max:255',
            'shortname' => 'required|max:15',
            'regcompname' => 'required|max:255',
            'regcompusername' => 'required|max:255|unique:users,username',
            'regcompemail' => 'required|email|max:255|unique:users,email',
            'regcomppassword' => 'required|confirmed|min:6',
        ])->setAttributeNames($customNames);  
    }

    protected function validatorUser(array $data)           //Validator for creation of User without Company
    {
        $customNames = array(
            'regusercode' => 'company code',
            'regusername' => 'name',
            'reguserusername' => 'username',
            'reguserpassword' => 'password',
            'reguseremail' => 'email',
        );
        return Validator::make($data, [
            'regusercode' => 'required|max:8|exists:companies,company_code',
            'regusername' => 'required|max:255',
            'reguserusername' => 'required|max:255|unique:users,username',
            'reguseremail' => 'required|email|max:255|unique:users,email',
            'reguserpassword' => 'required|confirmed|min:6',
        ])->setAttributeNames($customNames);  
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)      //Creation of Company
    {
        do
        {
            $code = str_random(8);
            $company = \App\Company::where('company_code', $code)->first();
        }
        while(!empty($company_code));
        $company_id = \App\Company::create([
            'name' => $data['company_name'],
            'shortname' => $data['shortname'],
            'company_code' => $code,
        ])->id;
        $company_role_id = \App\CompanyRole::create([
            'company_id' => $company_id,
            'role_id' => 2,
        ])->id;
        return User::create([
            'company_id' => $company_id,
            'company_role_id' => $company_role_id,
            'name' => $data['regcompname'],
            'username' => $data['regcompusername'],
            'email' => $data['regcompemail'],
            'password' => bcrypt($data['regcomppassword']),
            'isApproved' => true,
        ]);
    }

    protected function createUser(array $data)     //Creation of User without Company
    {
        $company = \App\Company::where('company_code', $data['regusercode'])->first();
        $company_id = $company ? $company->id : $company_id = 0;
        $company_role_id = \App\CompanyRole::create([
            'company_id' => $company_id,
            'role_id' => 1,
        ])->id;
        return User::create([
            'company_id' => $company_id,
            'company_role_id' => $company_role_id,
            'name' => $data['regusername'],
            'username' => $data['reguserusername'],
            'email' => $data['reguseremail'],
            'password' => bcrypt($data['reguserpassword']),
            'isApproved' => false,
        ]);
    }
}
