<?php

namespace App\Http\Controllers;

use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Item;
use App\User;
use App\Basket;
use App\ItemType;
use App\Advertisement;


class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            if(\Auth::user()->user_category_id == 5 || \Auth::user()->user_category_id == 0)
                {
                    $items = Item::all();
                    $baskets = Basket::all();
                }
            else if(\Auth::user()->user_category_id == 1)
                {
                    $items = Item::where('user_id', \Auth::user()->id)->get();
                    $baskets = Basket::where('user_id', \Auth::user()->id)->get();
                }
            elseif(\Auth::user()->user_category_id == 3)
            {
                // $parents = \Auth::user()->parents->where('user_category_id',2);
                $parents = \Auth::user()->parents()->where('user_category_id',2)->wherePivot('verified', '=', true)->wherePivot('freezed', '=', false)->get();
                $compsIdArr = [];
                foreach($parents as $p)
                {
                    array_push($compsIdArr, $p->parents->pluck('id'));
                }
                $items = Item::whereIn('user_id', $compsIdArr)->get();
                $baskets = Basket::where('user_id', \Auth::user()->id)->get();
            }
            else
            {
                $items = Item::whereIn('user_id', \Auth::user()->parents->pluck('id'))->get();
                $baskets = Basket::where('user_id', \Auth::user()->id)->get();   
            }
            $ads1 = Advertisement::whereIn('position', [5])->where('from_date', '<=', now())->orderBy('to_date', 'desc')->get();
            $ads2 = Advertisement::whereIn('position', [6])->where('from_date', '<=', now())->orderBy('to_date', 'desc')->get();
            return view('items.index', ['items'=>$items, 'baskets'=>$baskets, 'ads1'=>$ads1, 'ads2'=>$ads2]);}
        catch(\Exception $e)
        {dd($e);}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $comps = User::where('user_category_id',1)->get();
        return view('items.create', ['types'=>ItemType::all(), 'comps'=>$comps]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $item = new Item();
        if(\Auth::user()->category->id == 0)
            $item->user_id = request('user_id');
        else
            $item->user_id = \Auth::user()->id;
        $item->barcode = request('barcode');
        $item->name = request('name');
        $item->item_category_id = request('item_category_id');
        $item->composition = request('composition');
        $item->dosage = request('dosage');
        $item->descr1 = request('descr1');
        $item->descr2 = request('descr2');
        $item->price = request('price');
        $item->customer_price = request('customer_price');
        $item->titer = request('titer');
        $item->properties = request('properties');
        $item->package = request('package');
        $item->storage = request('storage');
        $item->extra = request('extra');
        $item->extra2 = request('extra2');
        $item->name_en = request('name_en');
        $item->composition_en = request('composition_en');
        $item->dosage_en = request('dosage_en');
        $item->descr1_en = request('descr1_en');
        $item->descr2_en = request('descr2_en');
        $item->properties_en = request('properties_en');
        $item->package_en = request('package_en');
        $item->storage_en = request('storage_en');
        $item->extra_en = request('extra_en');
        $item->extra2_en = request('extra2_en');
        $item->item_type_id = request('item_type_id');

        $item->save();

        return redirect('/items');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('items.show', ['item' => Item::findOrFail($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comps = User::where('user_category_id',1)->get();
        return view('items.edit', ['item' => Item::findOrFail($id), 'types'=>ItemType::all(), 'comps'=>$comps]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        if(\Auth::user()->category->id == 0)
            $item->user_id = request('user_id');
        $item->barcode = request('barcode');
        $item->name = request('name');
        $item->item_category_id = request('item_category_id');
        $item->composition = request('composition');
        $item->dosage = request('dosage');
        $item->descr1 = request('descr1');
        $item->descr2 = request('descr2');
        $item->price = request('price');
        $item->customer_price = request('customer_price');
        $item->titer = request('titer');
        $item->properties = request('properties');
        $item->package = request('package');
        $item->storage = request('storage');
        $item->extra = request('extra');
        $item->extra2 = request('extra2');
        $item->name_en = request('name_en');
        $item->composition_en = request('composition_en');
        $item->dosage_en = request('dosage_en');
        $item->descr1_en = request('descr1_en');
        $item->descr2_en = request('descr2_en');
        $item->properties_en = request('properties_en');
        $item->package_en = request('package_en');
        $item->storage_en = request('storage_en');
        $item->extra_en = request('extra_en');
        $item->extra2_en = request('extra2_en');
        $item->item_type_id = request('item_type_id');

        $item->save();
        
        
        return redirect('/items/'.$item->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Item::findOrFail($id)->delete();

        return redirect('/items');
    }
    public function import(Request $request) 
    {
        // dd(request()->file('items_file'));
        Excel::import(new ItemsImport, request()->file('items_file'));

        return redirect('/items');
    }
    public function importItems() 
    {
        return view('items.import');
    }
    protected function ajaxItemRequest(Request $request)
    {
        $comp =  \Auth::user()->id;
        $response = Item::where('user_id', $comp)->get();
        foreach($response as $res)
            {
                $res->item_type_id = $res->type->ar_name;
            }
        return $response;
    }
    protected function freezeItemByUser(Request $request)
    {
        try{
        $user =  \Auth::user();
        if($request->freeze == "true")
            $user->freezedItems()->attach($request->id,  ['freezed' => true]);
        else
            $user->freezedItems()->detach($request->id);
        return "";
    }
    catch(\Exception $e){dd($e);}
    }
}
