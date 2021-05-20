<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Item;
use App\User;
use App\Basket;
use App\Cart;
use App\ItemType;
use App\Order;
use App\Offer;


class OrdersController extends Controller
{
    public function getOrders()
    {
        if(in_array(\Auth::user()->user_category_id, [2,3,4]))
        $orders = Order::where('reciever_id', \Auth::user()->id)->with('items', 'sender', 'reciever')->get();
        else if(\Auth::user()->user_category_id == 5)
            $orders = Order::where('sender_id', \Auth::user()->id)->with('items', 'sender', 'reciever')->get();
        else if(\Auth::user()->user_category_id == 0)
            $orders = Order::with('items', 'sender', 'reciever')->get();
            
        return $orders;
    }

    public function getOffers()
    {
        if(\Auth::user()->user_category_id == 2 || \Auth::user()->user_category_id == 3)
        {
            $offers = Offer::where('user_id',\Auth::user()->id)->with('user', 'item', 'freeItem')->get();
            $baskets = Basket::where('user_id',\Auth::user()->id)->get();
        }
        else if(\Auth::user()->user_category_id == 5 || \Auth::user()->user_category_id == 0)
        {
            $offers = Offer::with('user', 'item', 'freeItem')->get();
            $baskets = Basket::all();
        }
        else
        {
            $offers = Offer::whereIn('user_id', \Auth::user()->parents->pluck('id'))->with('user', 'item', 'freeItem')->get();
            $baskets = Basket::whereIn('user_id', \Auth::user()->parents->pluck('id'))->get();
        }

        return $offers;
    }

    public function getCart()
    {
        $baskets = collect(new Basket);
        $carts = Cart::where('sender_id', \Auth::user()->id)->with('item', 'sender', 'reciever')->get();
        foreach($carts as $cart)
        {
            if($cart->is_basket)
            {
                $baskets->push(Basket::findOrFail($cart->item_id));
            }
        }
        return ['carts'=>$carts, 'baskets'=>$baskets];
    }
    public function addToCart(Request $request)
    {
        try{
        $freeQuant = 0;
        $cart = Cart::where(['sender_id' => \Auth::user()->id,'reciever_id'=>$request->reciever_id, 'item_id' => $request->item_id, 'is_basket'=>($request->isBasket == "true")])->get();
        if($cart->count() == 0){
            $cart = new Cart([
                'sender_id' => \Auth::user()->id,
                'reciever_id' => $request->reciever_id,
                'item_id' => $request->item_id,
                'remark' => $request->sender_remark,
                'quantity' => $request->quantity,
                'is_basket' => ($request->isBasket == "true")
            ]);
            if($request->isBasket == "true")
                {try{$price = $request->quantity * (Basket::findOrFail($request->item_id)->price);}
                catch(\Exception $e){dd($e);}
                }
            else
                {
                    $item = Item::findOrFail($request->item_id);
                    $currentOffers=$item->offers->where('to_date','>=',now())->where('user_id', $request->reciever_id);
                    if($currentOffers->count() > 0 && $currentOffers->where('discount','>', 0)->count() > 0 && $request->quantity >= $currentOffers->where('discount','>', 0)->first->quantity)
                    {
                        $item->price -= (float)$item->price * ($currentOffers->where('discount','>', 0)->first->discount->discount/100);
                    }
                    if($currentOffers->count() > 0 && $currentOffers->where('free_quant','>', 0)->count() > 0 && $request->quantity >= $currentOffers->where('free_quant','>', 0)->first->free_quant->quant && $request->item_id >= $currentOffers->where('free_quant','>', 0)->first->free_quant->free_item)
                    {
                        $freeQuant = (int) (($request->quantity / $currentOffers->where('free_quant','>', 0)->first->free_quant->quant) * $currentOffers->where('free_quant','>', 0)->first->free_quant->free_quant);
                    }
                    $price = (float)($request->quantity * $item->price);
                }
        $cart->price = $price;
        $cart->free_quant = $freeQuant;
        $cart->is_basket = ($request->isBasket == "true");
    }
        else{
            $cart = $cart->first();
            $quantity = $cart->quantity + $request->quantity;
            if($request->isBasket == "true")
                $price = $quantity * (Basket::findOrFail($request->item_id)->price);
            else
            {
                $item = Item::findOrFail($request->item_id);
                $currentOffers=$item->offers->where('to_date','>=',now())->where('user_id', $request->reciever_id);
                if($currentOffers->count() > 0 && $currentOffers->where('discount','>', 0)->count() > 0 && $quantity >= $currentOffers->where('discount','>', 0)->first->quantity)
                {
                    $item->price -= $item->price * ($currentOffers->where('discount','>', 0)->first->discount->discount/100);
                }
                if($currentOffers->count() > 0 && $currentOffers->where('free_quant','>', 0)->count() > 0 && $quantity >= $currentOffers->where('free_quant','>', 0)->first->free_quant->quant && $request->item_id >= $currentOffers->where('free_quant','>', 0)->first->free_quant->free_item)
                {
                    $freeQuant = (int) (($quantity / $currentOffers->where('free_quant','>', 0)->first->free_quant->quant) * $currentOffers->where('free_quant','>', 0)->first->free_quant->free_quant);
                }
                $price = $quantity * $item->price;
            }
            $cart->quantity = $quantity;
            $cart->free_quant = $freeQuant;
            $cart->price = $price;
        }
    }
        catch(\Exception $e){dd($e);}
        $cart->save();
        return '';
    }
    public function deleteFromCart($id)
    {
        Cart::findOrFail($id)->delete();

        return 'success';
    }
    public function deleteOffer($id)
    {
        Offer::findOrFail($id)->delete();

        return 'success';
    }
    public function getOrder($id)
    {
        return Order::where('id',$id)->with(['items','sender','reciever'])->get();
    }
    public function editCart(Request $request)
    {
        $carts = json_decode($request->carts, true);
        // dd($carts);
        foreach($carts as $cart)
        {
            $currentCart = Cart::findOrFail($cart["id"]);
            $quantity = $cart["quantity"];
            $freeQuant = 0;
            $price = 0;
            if((bool)$cart["is_basket"])
            {
                try{$price = $cart["quantity"] * (Basket::findOrFail($cart["item_id"])->price);}
                catch(\Exception $e){dd($e);}
            }
            else
            {
                $item = Item::findOrFail($cart["item_id"]);
                $currentOffers=$item->offers->where('to_date','>=',now())->where('user_id', $cart["reciever_id"]);
                if($currentOffers->count() > 0 && $currentOffers->where('discount','>', 0)->count() > 0 && $quantity >= $currentOffers->where('discount','>', 0)->first->quantity)
                {
                    $item->price -= $item->price * ($currentOffers->where('discount','>', 0)->first->discount->discount/100);
                }
                if($currentOffers->count() > 0 && $currentOffers->where('free_quant','>', 0)->count() > 0 && $quantity >= $currentOffers->where('free_quant','>', 0)->first->free_quant->quant && $request->item_id >= $currentOffers->where('free_quant','>', 0)->first->free_quant->free_item)
                {
                    $freeQuant = (int) (($quantity / $currentOffers->where('free_quant','>', 0)->first->free_quant->quant) * $currentOffers->where('free_quant','>', 0)->first->free_quant->free_quant);
                }
                $price = $quantity * $item->price;
            }
            $currentCart->quantity = $quantity;
            $currentCart->free_quant = $freeQuant;
            $currentCart->price = $price;
            $currentCart->save();
        }
        return "success";
        //
    }
    public function addAllItemsToCart(Request $request)
    {
        // dd($request->objects);
        try{
            $objects = json_decode($request->objects, true);
            // dd($objects);
            foreach($objects as $obj)
            {
                $obj = json_decode($obj);
                $freeQuant = 0;
                $cart = Cart::where(['sender_id' => \Auth::user()->id,'reciever_id'=>$obj->reciever, 'item_id' => $obj->id, 'is_basket'=>false])->get();
                if($cart->count() == 0){
                    $cart = new Cart([
                        'sender_id' => \Auth::user()->id,
                        'reciever_id' => $obj->reciever,
                        'item_id' => $obj->id,
                        'remark' => $obj->sender_remark,
                        'quantity' => $obj->quant,
                        'is_basket' => false
                    ]);
                    // if($request->isBasket == "true")
                    //     {try{$price = $request->quantity * (Basket::findOrFail($request->item_id)->price);}
                    //     catch(\Exception $e){dd($e);}
                    //     }
                    // else
                    //     {
                            $item = Item::findOrFail($obj->id);
                            $currentOffers=$item->offers->where('to_date','>=',now())->where('user_id', $obj->reciever);
                            if($currentOffers->count() > 0 && $currentOffers->where('discount','>', 0)->count() > 0 && $obj->quant >= $currentOffers->where('discount','>', 0)->first->quantity)
                            {
                                $item->price -= (float)$item->price * ($currentOffers->where('discount','>', 0)->first->discount->discount/100);
                            }
                            if($currentOffers->count() > 0 && $currentOffers->where('free_quant','>', 0)->count() > 0 && $obj->quant >= $currentOffers->where('free_quant','>', 0)->first->free_quant->quant && $obj->id >= $currentOffers->where('free_quant','>', 0)->first->free_quant->free_item)
                            {
                                $freeQuant = (int) (($obj->quant / $currentOffers->where('free_quant','>', 0)->first->free_quant->quant) * $currentOffers->where('free_quant','>', 0)->first->free_quant->free_quant);
                            }
                            $price = (float)($obj->quant * $item->price);
                        // }
                $cart->price = $price;
                $cart->free_quant = $freeQuant;
                $cart->is_basket = false;
            }
                else{
                    $cart = $cart->first();
                    $quantity = $cart->quantity + $obj->quant;
                        $item = Item::findOrFail($obj->id);
                        $currentOffers=$item->offers->where('to_date','>=',now())->where('user_id', $obj->reciever);
                        if($currentOffers->count() > 0 && $currentOffers->where('discount','>', 0)->count() > 0 && $quantity >= $currentOffers->where('discount','>', 0)->first->quantity)
                        {
                            $item->price -= $item->price * ($currentOffers->where('discount','>', 0)->first->discount->discount/100);
                        }
                        if($currentOffers->count() > 0 && $currentOffers->where('free_quant','>', 0)->count() > 0 && $quantity >= $currentOffers->where('free_quant','>', 0)->first->free_quant->quant && $obj->id >= $currentOffers->where('free_quant','>', 0)->first->free_quant->free_item)
                        {
                            $freeQuant = (int) (($quantity / $currentOffers->where('free_quant','>', 0)->first->free_quant->quant) * $currentOffers->where('free_quant','>', 0)->first->free_quant->free_quant);
                        }
                        $price = $quantity * $item->price;
                    
                    $cart->quantity = $quantity;
                    $cart->free_quant = $freeQuant;
                    $cart->price = $price;
                }
                $cart->save();
            }
        }
        catch(\Exception $e){dd($e);}
        return "success";
    }
    public function makeOrder(Request $request){
        if($request->reciever == null)
            $thisCarts = Cart::where('sender_id',\Auth::user()->id)->get();
        else
            $thisCarts = Cart::where(['sender_id'=>\Auth::user()->id,'reciever_id'=>$request->reciever])->get();
        $groupCarts = $thisCarts->groupBy('reciever_id');
        foreach($groupCarts as $gCart)
        {
            $order = new Order([
                'sender_id' => $gCart->first()->sender_id,
                'reciever_id' => $gCart->first()->reciever_id,
                'remark' => $request->remark,
                'price' => $gCart->sum('price'),
            ]);
            if($order->save())
            {
                $baskets = $gCart->groupBy('is_basket');
                foreach($baskets as $basket)
                {
                    $items = $basket->groupBy('item_id');
                    if((bool)$basket->first()->is_basket)
                    {
                        foreach($items as $item)
                        {
                                try{$order->baskets()->attach($item->first()->item_id,  ['quantity' => $item->sum('quantity')]);}
                                catch(\Exception $e){dd($e);}
                        }
                    }
                    else
                    {
                        foreach($items as $item)
                        {
                            $remark = $item->first()->remark;
                                try{$order->items()->attach($item->first()->item_id,  ['quantity' => $item->sum('quantity'), 'free_quant'=> $item->sum('free_quant'), 'price' => $item->sum('price'), 'sender_remark'=>$remark]);}
                                catch(\Exception $e){dd($e);}
                        }
                    }
                }
            }
        }
        $ids_to_delete = $thisCarts->pluck('id');
        Cart::whereIn('id', $ids_to_delete)->delete();
        return "success";
    }
    public function verifyOrder(Request $request){
        $order = Order::findOrFail($request->id);
        $order->verified_at = now();        
        if($order->save())
            return "success";
    }
}