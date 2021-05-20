<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\User;
use App\Country;

class UserRelationsController extends Controller
{
    public function availableChildren()
    {

        if(\Auth::user()->category->id == 1)
            $availableChildren = \Auth::user()->children;
        else if(\Auth::user()->category->id == 2)
            $availableChildren = User::whereIn('user_category_id', array(3, 5))->get();
        // else if(\Auth::user()->category->id == 3)
        //     $availableChildren = User::where('user_category_id',5)->get();

        foreach($availableChildren as $availableChild){
            try{
                $available = DB::table('user_relations')->where(['parent_id'=> \Auth::user()->id, 'child_id'=>$availableChild->id])->exists();
                $isFreezed = (bool)DB::table('user_relations')->where(['parent_id'=> \Auth::user()->id, 'child_id'=>$availableChild->id])->value('freezed');
                $isVerified = (bool)DB::table('user_relations')->where(['parent_id'=> \Auth::user()->id, 'child_id'=>$availableChild->id])->value('verified');
                $availableChild->setAttribute('isFreezed', $available && $isFreezed);
                $availableChild->setAttribute('isVerified', $available && $isVerified);
            }
                catch(\Exception $e){dd($e);}
            }
        // foreach($agents as $agent){dd($agent->parents);}
        return view('userRelations.availableChildren.index', ['availableChildren'=>$availableChildren]);
    }

    public function freezeRelation(Request $request)
    {
        $freezed =  ($request->freezed === 'true');
        try{
            if(\Auth::user()->category->id != 4)
                return DB::update('update user_relations set freezed = ? where parent_id = ? and child_id = ?',[$freezed,\Auth::user()->id,$request->id]);
            else
                return DB::update('update user_relations set freezed = ? where parent_id = ? and child_id = ?',[$freezed,$request->id,\Auth::user()->id]);
        }
        catch(\Excepton $e){return ($e);}
    }
    public function verifyRelation(Request $request)
    {
        try{
            if(\Auth::user()->category->id == 1 || \Auth::user()->category->id == 2)
                return DB::update('update user_relations set verified = ? where parent_id = ? and child_id = ?',[true,\Auth::user()->id,$request->id]);
        }
        catch(\Excepton $e){return ($e);}
    }
    public function requestRelation(Request $request)
    {
        $freezed =  ($request->freezed === 'true');
        try{
            $child = User::findOrFail(\Auth::user()->id);
            $child->parents()->attach($request->id);
            return $request->id;
        }
        catch(\Excepton $e){return ($e);}
    }

    public function availableParents()
    {
        if(\Auth::user()->category->id == 4 || \Auth::user()->category->id == 2)
            $availableParents = User::where(['user_category_id'=>1])->get();
        else if(\Auth::user()->category->id == 3)
            $availableParents = User::where(['user_category_id'=>2])->get();
        if(\Auth::user()->category->id == 4 || \Auth::user()->category->id == 1)
        {foreach($availableParents as $availableParent){
            try{
                $available = DB::table('user_relations')->where(['child_id'=> \Auth::user()->id, 'parent_id'=>$availableParent->id])->exists();
                $isFreezed = (bool)DB::table('user_relations')->where(['child_id'=> \Auth::user()->id, 'parent_id'=>$availableParent->id])->value('freezed');
                $isVerified = (bool)DB::table('user_relations')->where(['child_id'=> \Auth::user()->id, 'parent_id'=>$availableParent->id])->value('verified');
                $availableParent->setAttribute('isFreezed', $available && $isFreezed);
                $availableParent->setAttribute('isVerified', $available && $isVerified);
            }
                catch(\Exception $e){dd($e);}
            }
        }
        // foreach($agents as $agent){dd($agent->parents);}
        return view('userRelations.availableParents.index', ['availableParents'=>$availableParents]);
    }

    public function addChild(Request $request)
    {
        try{
        // $time = Carbon\Carbon::now();
        $parent = User::findOrFail(\Auth::user()->id);
        $parent->children()->attach($request->id);
        return $request->id;}
        catch(\Exception $e){return $e;}
    }

    public function delUser(Request $request)
    {
        try{
            $usr = User::findOrFail(request()->id);
            if($usr->items->count()==0 
            && $usr->ordersFromUser->count()==0
            && $usr->ordersToUser->count()==0
            && $usr->cartsFromUser->count()==0
            && $usr->cartsToUser->count()==0
            && $usr->posts->count()==0
            && $usr->offers->count()==0
            && $usr->quantities->count()==0
            && $usr->baskets->count()==0){
            $usr->children()->detach();
            $usr->parents()->detach();
            $usr->delete();}
            return \redirect()->route('allUsers');}
        catch(\Exception $e){return $e;}
    }

    public function showUsr(Request $request)
    {
        try{
            $dists = null;
            $parent = User::findOrFail(request()->id);
            if($parent->user_category_id == 2)
            {
            $dists = User::where(['user_category_id'=>3])->whereDoesntHave('parents', function($query) {
                $query->where('parent_id', request()->id);
              })->get();
            }
            // dd($parent->parents->where('id',\Auth::user()->id)->first()->pivot->freezed);
            return view('userRelations.show', ['dists'=>$dists, 'user'=>$parent]);}
        catch(\Exception $e){dd($e);}
    }
    public function saveDist(Request $request)
    {
        try{
            $parent = User::findOrFail(request()->id);
            $parent->children()->attach([$request->dist => ['verified'=>true]]);

            return \redirect()->route('allUsers');}
        catch(\Exception $e){dd($e);}
    }

    public function addParent(Request $request)
    {
        try{
        // $time = Carbon\Carbon::now();
        $child = User::findOrFail(\Auth::user()->id);
        $child->parents()->attach($request->id);
        return $request->id;}
        catch(\Exception $e){return $e;}
    }
    public function showFavAg()
    {
        if(\Auth::user()->category->id == 5)
            $agents = \Auth::user()->children()->wherePivot('comp_id','>',0)->get();
        foreach($agents as $ag)
            $ag->username = User::find($ag->pivot->comp_id)->f_name;
        return view('userRelations.FavAg.index', ['agents'=>$agents]);
    }
    public function addFavAg()
    {
        $comps = User::where('user_category_id',1)->get();
        $agents = $comps->first()->children->whereIn('user_category_id',[2,3,4]);
        foreach($agents->where('user_category_id',2) as $child)
            foreach($child->children as $chd)
                if (!$agents->contains('id', $chd->id))
                    $agents->push($chd);
        return view('userRelations.FavAg.create', ['agents'=>$agents,'comps'=>$comps]);
    }
    protected function ajaxFavAgRequest(Request $request)
    {
        try{
            // dd(request()->comp);
        $comp =  User::findOrFail(request()->comp);
        $response = $comp->children->whereIn('user_category_id',[2,3,4])->where('city', \Auth::user()->city);
        foreach($comp->children->where('user_category_id',2) as $child)
            foreach($child->children as $chd)
                if (!$response->contains('id', $chd->id))
                    $response->push($chd);        
        return $response;}
        catch(\Exception $e){return dd($e);}
    }
    public function createFavAg(Request $request)
    {
        \Auth::user()->children()->attach($request->agent, ['comp_id' => $request->company]);
        return redirect('/userRelations/showFav');
    }
    public function removeFavAg(Request $request)
    {
        \Auth::user()->children()->wherePivot('comp_id',$request->comp_id)->detach($request->id);
        return redirect('/userRelations/showFav');
    }
}
