<?php

namespace App\Http\Controllers;

use App\Advertisement;
use App\User;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads = Advertisement::all();
        return view('ads.index', ['ads'=>$ads]);
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usrs = User::where('user_category_id', '!=' , 0)->get();
        return view('ads.create',['usrs'=>$usrs]);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(request()->has('ad_image'))
        {
            $uploadedImg = request()->file('ad_image');
            $fileName = time() . '.' . $uploadedImg->getClientOriginalExtension();
            $uploadPath = public_path('/images/e3lan/');
            $uploadedImg->move($uploadPath, $fileName);
        }
        else
        {
            $fileName = 'default_ad.png';
        }
        $ad = new Advertisement();
        $ad->user_id = request('user_id');
        $ad->from_date = request('from_date');
        $ad->to_date = request('to_date');
        $ad->position = request('position');
        $ad->text = request('text');
        $ad->keep = (request('keep')!=null);
        $ad->image_url = '/images/e3lan/'.$fileName;
        $ad->save();

        return redirect('/ads');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Advertisement::findOrFail($id)->delete();
        return redirect('/ads');
    }
    public function stop($id)
    {
        //
    }
}
