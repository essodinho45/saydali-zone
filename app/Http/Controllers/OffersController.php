<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offer;
use App\Basket;
use App\Item;

class OffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->user_category_id == 2 || \Auth::user()->user_category_id == 3)
        {
            $offers = Offer::where('user_id',\Auth::user()->id)->get();
            $baskets = Basket::where('user_id',\Auth::user()->id)->get();
        }
        else if(\Auth::user()->user_category_id == 5 || \Auth::user()->user_category_id == 0)
        {
            $offers = Offer::all();
            $baskets = Basket::all();
        }
        else
        {
            $offers = Offer::whereIn('user_id', \Auth::user()->parents->pluck('id'))->get();
            $baskets = Basket::whereIn('user_id', \Auth::user()->parents->pluck('id'))->get();
        }
            return view('offers.index', ['offers'=>$offers, "baskets"=>$baskets]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(\Auth::user()->category->id == 2)
            $items = Item::whereIn('user_id', \Auth::user()->parents->pluck('id'))->get();
        elseif(\Auth::user()->category->id == 3)
            $items = Item::whereIn('user_id', \Auth::user()->parents->parents->pluck('id'))->get();
        elseif(\Auth::user()->category->id == 0)
            $items = Item::all();
        return view('offers.create', ['items'=>$items]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->offer_type == 3)
            {
                $offer = new Basket();
                $offer->user_id = \Auth::user()->id;
                $offer->remark = $request->remark;
                $offer->name = $request->name;
                $offer->price = $request->price;
                $offer->from_date = $request->from_date;
                $offer->to_date = $request->to_date;
                try{$offer->save();}
                catch(\Exception $e){dd($e);}
                $basket_items = explode( ',', $request->basket_info );
                foreach($basket_items as $item)
                {
                    $item = explode( '-', $item );
                    $offer->items()->attach((int)$item[0],  ['quantity' => (int)$item[1]]);
                }
            }
        else
            {
                try{
                $offer = new Offer();
                $offer->user_id = \Auth::user()->id;
                $offer->item_id = $request->item_id;
                $offer->remark = $request->remark;
                $offer->from_date = $request->from_date;
                $offer->to_date = $request->to_date;
                $offer->discount = $request->discount ?? 0;
                $offer->free_quant = $request->free_quant ?? 0;
                $offer->quant = $request->quant ?? 0;
                $offer->free_item = $request->free_item;
                $offer->save();}
                catch(\Exception $e){dd($e);}
            }
            return redirect('/offers');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($type, $id)
    {
        if((int)$type == 1)
        {
            try{
            Offer::findOrFail((int)$id)->delete();}
            catch(\Exception $e){dd($e);}
        }
        else 
        if((int)$type == 2)
        {
            Basket::findOrFail((int)$id)->items()->detach(); 
            Basket::findOrFail((int)$id)->orders()->detach(); 
            Basket::findOrFail((int)$id)->delete(); 
        }
        return redirect('/offers');
    }
}
