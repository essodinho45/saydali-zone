<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use App\Country;
use App\City;
use App\Http\Controllers\LoginController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    protected $redirectTo = '/home';

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
    public function apiRegister(Request $request)
    {
        try{
        $this->validator($request->json()->all())->validate();
        }
        catch(\Exception $e)
        {return $e->validator->errors();}

        event(new Registered($user = $this->create($request->json()->all())));

        return "confirm";
    }
    protected function validator(array $data)
    {
        $val = Validator::make($data, [
            'f_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            's_name' => ['nullable', 'string', 'max:255'],
            'commercial_name' => ['nullable', 'string', 'max:255'],
            'user_category_id' => [ 'string', 'required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'email2' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'licence_number'=>['nullable','string','required_if:user_category_id,5'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'country' => ['required', 'string', 'max:3'],
            'city' => [ 'nullable','string', 'max:255'],
            'region' => [ 'nullable','string', 'max:255'],
            'address' => [ 'nullable','string', 'max:255'],
            'tel1' => [ 'nullable','string', 'max:255'],
            'tel2' => [ 'nullable','string', 'max:255'],
            'mob1' => [ 'required','string', 'max:255'],
            'mob2' => [ 'nullable','string', 'max:255'],
            'tel2' => [ 'nullable','string', 'max:255'],
            'fax1' => [ 'nullable','string', 'max:255'],
            'fax2' => [ 'nullable','string', 'max:255'],
            'logo_image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,bmp,svg', 'max:5000']
        ]);
        return $val;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if(request()->has('logo_image'))
        {
            $uploadedImg = request()->file('logo_image');
            $fileName = time() . '.' . $uploadedImg->getClientOriginalExtension();
            $uploadPath = public_path('/images/logos/');
            $uploadedImg->move($uploadPath, $fileName);
        }
        else
        {
            $fileName = 'default_logo.png';
        }
        try{
            $this->validator($data)->validate();
        }
        catch(\Exception $e) {
            // dd($e->validator->errors());
            // return $e->validator->errors();
            return back()->with('error',$e->validator->errors());
        }

        return User::create([
            'f_name' => $data['f_name'],
            's_name' => $data['s_name'],
            'commercial_name' => $data['commercial_name'],
            'username' => $data['username'],
            'user_category_id' => $data['user_category_id'],
            'email' => $data['email'],
            'email2' => $data['email2'],
            'licence_number' => $data['licence_number'],
            'country' => $data['country'],
            'city' => $data['city'],
            'region' => $data['region'],
            'address' => $data['address'],
            'tel1' => $data['tel1'],
            'tel2' => $data['tel2'],
            'mob1' => '963' . ltrim($data['mob1'], '0'),
            'mob2' => $data['mob2'],
            'fax1' => $data['fax1'],
            'fax2' => $data['fax2'],
            'logo_image' => '/images/logos/'.$fileName,
            'password' => Hash::make($data['password']),
            'api_token' => Str::random(60),
        ]);
    }
    public function showRegistrationForm()
    {
        $countries=Country::all();
        $cities=City::where('country', '1')->get();
        return view('auth.register', ['countries'=>$countries, 'cities'=>$cities]);
    }
}
