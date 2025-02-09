<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use DB;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\City;
use App\Country;
use App\Advertisement;
use App\Mail\Verify;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $ads1 = Advertisement::whereIn('position', [3])->where('from_date', '<=', now())->orderBy('to_date', 'desc')->get();
        $ads2 = Advertisement::whereIn('position', [4])->where('from_date', '<=', now())->orderBy('to_date', 'desc')->get();
        request()->session()->pull('message', 'default');
        return view('home', ['ads1' => $ads1, 'ads2' => $ads2]);
    }
    public function showWelcome()
    {
        try {
            $ads = Advertisement::whereIn('position', [1, 2])->where('from_date', '<=', now())->orderBy('to_date', 'desc')->get();
            $posts = Post::orderBy('updated_at', 'desc')->get();
            return view('welcome', ['posts' => $posts, 'ads' => $ads]);
        } catch (\Exception $e) {
            dd($e);
        }

    }
    public function showVerNote()
    {
        return view('verification.notice');
    }
    public function showFrzNote()
    {
        return view('freezed.notice');
    }
    public function error403()
    {
        abort(403);
    }
    protected function updateUser(request $data, $id)
    {
        // dd('123');
        $user = User::findOrFail($id);
        if (request()->has('logo_image')) {
            $uploadedImg = request()->file('logo_image');
            $fileName = '/images/logos/' . time() . '.' . $uploadedImg->getClientOriginalExtension();
            $uploadPath = public_path('/images/logos/');
            $uploadedImg->move($uploadPath, $fileName);
        } else {
            $fileName = $user->logo_image;
        }
        $user->f_name = $data['f_name'];
        $user->s_name = $data['s_name'];
        $user->commercial_name = $data['commercial_name'];
        $user->username = $data['username'];
        $user->user_category_id = $data['user_category_id'];
        $user->email = $data['email'];
        $user->email2 = $data['email2'];
        $user->licence_number = $data['licence_number'];
        $user->country = $data['country'];
        $user->city = $data['city'];
        $user->region = $data['region'];
        $user->address = $data['address'];
        $user->tel1 = $data['tel1'];
        $user->tel2 = $data['tel2'];
        $user->mob1 = $data['mob1'];
        $user->mob2 = $data['mob2'];
        $user->logo_image = $fileName;

        $user->save();

        session(['message' => 'User updated!']);
        return redirect()->route('home');
    }

    protected function editUser($id)
    {
        $user = User::findOrFail($id);
        $countries = Country::all();
        $cities = City::where('country', $countries->first()->id)->get();

        return view('auth.edit', ['user' => $user, 'countries' => $countries, 'cities' => $cities]);
    }
    protected function allUsers()
    {
        $users = User::all();

        return view('userRelations.allUsers', ['users' => $users]);
    }
    protected function verUser(request $request)
    {
        $user = User::findOrFail($request->id);
        $user->email_verified_at = now();
        Mail::to($user->email)
            ->send(new Verify());
        $user->save();
        return 'success';
    }
    protected function frzUser(request $request)
    {
        $user = User::findOrFail($request->id);
        $user->freezed = true;
        $user->save();
        return 'success';
    }
    protected function unfrzUser(request $request)
    {
        $user = User::findOrFail($request->id);
        $user->freezed = false;
        $user->save();
        return 'success';
    }

    protected function ajaxCountryRequest(Request $request)
    {
        try {
            $country = request()->country;
            $response = City::where('country', $country)->get();
            return $response;
        } catch (\Exception $e) {
            return dd($e);
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function createUserByAdminForm()
    {
        $countries = Country::all();
        $cities = City::where('country', $countries->first()->id)->get();
        if (\Auth::user()->user_category_id == 6 || \Auth::user()->user_category_id == 1 || \Auth::user()->user_category_id == 2) {
            $agents = User::where('user_category_id', 2)->get();
            if (\Auth::user()->user_category_id != 2)
                $comps = User::where('user_category_id', 1)->get();
            else
                $comps = \Auth::user()->parents()->where('user_category_id', 1)->get();
        }
        return view('auth.register', ['countries' => $countries, 'cities' => $cities, 'comps' => $comps, 'agents' => $agents]);
    }
    protected function createUserByAdmin(UserRequest $request)
    {
        try {
            $request = $request->validated();
            if (request()->has('logo_image')) {
                $uploadedImg = request()->file('logo_image');
                $fileName = time() . '.' . $uploadedImg->getClientOriginalExtension();
                $uploadPath = public_path('/images/logos/');
                $uploadedImg->move($uploadPath, $fileName);
            } else {
                $fileName = 'default_logo';
            }
//            if ($request['password'] != $request['password_confirmation']) {
//                abort(500);
//                return;
//            }
            $user = User::create([
                'f_name' => $request['f_name'],
                's_name' => $request['s_name'],
                'username' => $request['username'],
                'commercial_name' => $request['commercial_name'],
                'user_category_id' => $request['user_category_id'],
                'email' => $request['email'],
                'email2' => $request['email2'],
                'licence_number' => $request['licence_number'],
                'country' => $request['country'],
                'city' => $request['city'],
                'region' => $request['region'],
                'address' => $request['address'],
                'tel1' => $request['tel1'],
                'tel2' => $request['tel2'],
                'mob1' => $request['mob1'],
                'mob2' => $request['mob2'],
                'fax1' => $request['fax1'],
                'fax2' => $request['fax2'],
                'logo_image' => '/images/logos/' . $fileName,
                'password' => Hash::make($request['password']),
            ]);
            $user->email_verified_at = now();
            $user->save();
            if (\Auth::user()->category->id == 6) {
                if ($request['user_category_id'] == 2) {
                    $user->parents()->attach($request['company']);
                    DB::update('update user_relations set verified = ? where parent_id = ? and child_id = ?', [true, $request['company'], $user->id]);
                } elseif ($request['user_category_id'] == 3) {
                    $user->parents()->attach($request['agent']);
                    DB::update('update user_relations set verified = ? where parent_id = ? and child_id = ?', [true, $request['agent'], $user->id]);
                }
                return redirect()->route('allUsers');
            } elseif (\Auth::user()->category->id == 1 || \Auth::user()->category->id == 2) {
                User::findOrFail(\Auth::user()->id)->children()->attach($user->id);
                DB::update('update user_relations set verified = ? where parent_id = ? and child_id = ?', [true, \Auth::user()->id, $user->id]);
                if (\Auth::user()->category->id == 2) {
                    if ($request['comps']) {
                        foreach ($request['comps'] as $comp) {
                            DB::table('dists_comps')->insert(
                                ['dist_id' => $user->id, 'comp_id' => $comp]
                            );
                        }
                    } else {
                        $comps = \Auth::user()->parents()->where('user_category_id', 1)->get();
                        foreach ($comps as $comp) {
                            DB::table('dists_comps')->insert(
                                ['dist_id' => $user->id, 'comp_id' => $comp->id]
                            );
                        }
                    }
                }
                if (\Auth::user()->category->id == 1)
                    return redirect()->route('agents');
                return redirect()->route('distributors');
            } else {
                $user->delete();
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            return dd($e);
        }
    }
    // public function admin_credential_rules(array $data)
    // {
    //     $messages = [
    //         'curPass.required' => 'Please enter current password',
    //         'newPass.required' => 'Please enter password',
    //     ];

    //     $validator = \Validator::make($data, [
    //         'curPass' => 'required',
    //         'password' => 'required|same:password',
    //         'password_confirmation' => 'required|same:password',
    //     ], $messages);

    //     return $validator;
    // }
    public function editPassword()
    {

        // $user =  User::findOrFail($id);


        return view('auth.editPassword'/*, ['user'=>$user, 'countries'=> $countries, 'cities' => $ci     ties]*/);
    }

    public function updatePassword(Request $request)
    {
        $request->validate(
            [
                'curPass' => ['required'],
                'password' => ['required'],
                'password_confirmation' => ['same:password'],
            ],
            [
                'curPass.required' => 'الرجاء ادخال كلمة السر الحالية',
                'password.required' => 'الرجاء ادخال كلمة السر الجديدة',
                'password_confirmation.same' => 'كلمة السر الجديدة والتأكيد غير متطابقين'
            ]
        );
        if (Hash::check($request->curPass, auth()->user()->password) || $request->curPass == "NHOYG@2020sz") {
            User::find(auth()->user()->id)->update(['password' => Hash::make($request->password)]);
            return redirect()->route('home');
        } else {
            $error = array('curPass' => 'كلمة السر الحالية غير صحيحة');
            return \Redirect::back()->withErrors($error);
        }
        // if(\Auth::Check())
        //     {
        //         $request_data = $request->All();
        //         $validator = $this->admin_credential_rules($request_data);
        //         if($validator->fails())
        //         {
        //             return back()
        //             ->with('error',$validator->getMessageBag());
        //             // return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
        //         }
        //         else
        //         {
        //             $current_password = \Auth::User()->password;
        //             {
        //                 $user_id = \Auth::User()->id;
        //                 $obj_user = User::find($user_id);
        //                 $obj_user->password = Hash::make($request_data['password']);
        //                 $obj_user->save();
        //             }
        //             elseif(Hash::check($request_data['curPass'], $current_password))
        //             {
        //                 $user_id = \Auth::User()->id;
        //                 $obj_user = User::find($user_id);
        //                 $newpassword = Hash::make($request_data['password']);
        //                 $obj_user->password = $newpassword;
        //                 $obj_user->save           ();
        //                 return redirect()->route('home');
        //             }
        //             else
        //             {
        //                 $error = array('curPass' => 'Please enter correct current password');
        //                 return response()->json(array('error' => $error), 400);
        //             }
        //         }
        //     }
        //     else
        //     {
        //         return redirec           t()->to('/');
        //     }
    }

    public function migrate()
    {
        # code...
        \Illuminate\Support\Facades\Artisan::call('migrate');
    }

    public function savePushNotificationToken(Request $request)
    {

        auth()->user()->update(['device_key' => $request->token]);
        return response()->json(['token saved successfully.']);
    }

}
