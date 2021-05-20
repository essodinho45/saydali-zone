<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Country;
use App\Advertisement;
use App\City;



class ApiController extends Controller
{
    public function getCountries()
    {
        return Country::all();
    }
    public function getCities($id)
    {
        return City::where('country', $id)->get();
    }
    public function getAds($id)
    {
        return Advertisement::whereIn('position', [$id,$id+1])->where('from_date', '<=', now())->orderBy('to_date', 'desc')->get();
    }
}