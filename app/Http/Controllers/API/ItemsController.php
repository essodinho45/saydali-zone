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

    public function itemsByAgent($agent_id)
    {
        // $agents = User::whereIn('user_category_id',[2,3])->get();
        if($agent_id == 0)
            {
                $items = Item::all();
                $baskets = Basket::all();
            }
        else
            {
                $agent = User::find($agent_id);
                if($agent->category->name == "Agent")
                    $ids_array = $agent->parents->pluck('id')->toArray();
                elseif($agent->category->name == "Distributor")
                {
                    $parents = $agent->parents()->where('user_category_id',2)->wherePivot('verified', '=', true)->wherePivot('freezed', '=', false)->get();
                    $ids_array = [];
                    foreach($parents as $p)
                    {
                        foreach($p->parents->pluck('id')->toArray() as $pid)
                            array_push($ids_array, $pid);
                    }
                }
                array_push($ids_array, (int)$agent_id);
                // $non_allowed_ids = DB::table('dists_comps')->select('comp_id')->where('dist_id', $agent_id)->get();
                $items = Item::whereIn('user_id', $ids_array)->get();
                $baskets = Basket::whereIn('user_id', $ids_array)->get();
            }
            return [$items, $baskets];        
    }

    public function getAgents($id, $is_basket)
    {
        try{
            if($is_basket != '0' && $is_basket != 'false')
                return  Basket::findOrFail($id)->user;
            else{
                if($id == '0' || $id == 0)
                    return User::whereIn('user_category_id',[2,3,4])->get();
                $item =  Item::findOrFail($id);

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