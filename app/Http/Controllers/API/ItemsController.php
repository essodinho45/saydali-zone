<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Item;
use App\User;
use App\Basket;
use App\ItemType;


class ItemsController extends Controller
{
    public function getItems()
    {
        if(\Auth::user()->category->id == 5)
            return Item::with('company', 'offers')->get();
            // return Item::paginate(config('app.pages'));
        else if(\Auth::user()->category->id == 2 || \Auth::user()->category->id == 4)
        {
            return Item::whereIn('user_id', \Auth::user()->parents->pluck('id'))->with('company', 'offers')->get();
        }
        else if(\Auth::user()->category->id == 3)
        {
            $parents = \Auth::user()->parents()->where('user_category_id',2)->wherePivot('verified', '=', true)->wherePivot('freezed', '=', false)->get();
            $compsIdArr = [];
            foreach($parents as $p)
            {
                array_push($compsIdArr, $p->parents->pluck('id'));
            }
            return Item::whereIn('user_id', $compsIdArr)->with('company', 'offers')->get();
        }
    }

    public function getAgents(Request $request)
    {
        try{
            if($request->isBasket == "true")
                return  Basket::findOrFail($request->id)->user;
            else{
                $item =  Item::findOrFail($request->id);

                $allAgents = $item->company->children->filter(function($value, $key) {
                if (($value['user_category_id'] == 2 || $value['user_category_id'] == 4) && $value['city'] == \Auth::user()->city) {return true;}
                });
                $c = collect();

                foreach($allAgents as $key => $value){
                $isFreezed = (bool)(DB::table('user_relations')->where(['child_id'=> $value->id, 'parent_id'=>$item->company->id])->value('freezed'));
                if($isFreezed){
                    $allAgents->forget($key);
                    }
                }
                
                foreach($allAgents as $agent){
                    $c = $c->concat($agent->children->where('user_category_id', 3));
                }
                $allAgents = $allAgents->concat($c);

    
                $favAg = \Auth::user()->children()->wherePivot('comp_id','=',$item->company->id)->get();
                foreach($allAgents as $key => $value){
                    if($favAg->contains('id',$value->id))
                        $allAgents->forget($key);
                }
                foreach($favAg as $fA)
                    $allAgents->prepend($fA);
                    
                foreach($allAgents as $key => $value){

                    if($item->isFreezedByUser($value->id)){
                        $allAgents->forget($key);
                    }
                }
            }
        }
        catch(\Exception $e){dd($e);}
        return $allAgents->unique();
    }

    public function getBaskets()
    {
        if(\Auth::user()->category->id == 5)
            return Basket::paginate(config('app.pages'));
        else if(\Auth::user()->category->id == 2 || \Auth::user()->category->id == 4 || \Auth::user()->category->id == 3)
        {
            return Basket::where('user_id', \Auth::user()->id)->paginate(config('app.pages'));
        }
    }
}