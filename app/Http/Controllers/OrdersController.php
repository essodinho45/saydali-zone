<?php

namespace App\Http\Controllers;

use Constants;
use DB;
use Carbon\Carbon;
use Cookie;
use Illuminate\Http\Request;
use App\Item;
use App\User;
use App\Cart;
use App\Order;
use App\Basket;
use App\Offer;
use Illuminate\Support\Facades\Log;

class OrdersController extends Controller
{
    // use SendNotification;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (in_array(\Auth::user()->user_category_id, [2, 3, 4])) {
            $orders = Order::where('reciever_id', \Auth::user()->id);
            $last_order_id = clone $orders;
            $last_order_id = $last_order_id->orderByDesc('created_at')->first()->id ?? null;
            Cookie::queue('last-seen-orders', $last_order_id);
        } else if (\Auth::user()->user_category_id == 5)
            $orders = Order::where('sender_id', \Auth::user()->id);
        else if (\Auth::user()->user_category_id == 6)
            $orders = Order::query();
        $orders = $orders->orderByDesc('created_at')->get();
        return view('orders.index', ['orders' => $orders]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->reciever == null)
            $thisCarts = Cart::where('sender_id', \Auth::user()->id)->get();
        else
            $thisCarts = Cart::where(['sender_id' => \Auth::user()->id, 'reciever_id' => $request->reciever])->get();
        $groupCarts = $thisCarts->groupBy('reciever_id');
        foreach ($groupCarts as $gCart) {
            $order = new Order([
                'sender_id' => $gCart->first()->sender_id,
                'reciever_id' => $gCart->first()->reciever_id,
                'remark' => $request->remark,
                'price' => $gCart->sum('price'),
            ]);
            if ($order->save()) {
                $baskets = $gCart->groupBy('is_basket');
                foreach ($baskets as $basket) {
                    $items = $basket->groupBy('item_id');
                    if ((bool) $basket->first()->is_basket) {
                        foreach ($items as $item) {
                            $order->baskets()->attach($item->first()->item_id, ['quantity' => $item->sum('quantity')]);
                        }
                    } else {
                        foreach ($items as $item) {
                            $remark = $item->first()->remark;
                            $order->items()->attach($item->first()->item_id, ['quantity' => $item->sum('quantity'), 'free_quant' => $item->sum('free_quant'), 'price' => $item->sum('price'), 'sender_remark' => $remark]);
                        }
                    }
                }
                // $response = $this->sendPushNotification($gCart->first()->reciever_id, $gCart->first()->sender_id, "User ".User::where('id', $gCart->first()->sender_id)->first()->f_name." ".User::where('id', $gCart->first()->sender_id)->first()->s_name." sent an order.");
                // if($response["success"] == 1)
                // {

                // }
            }
        }
        $ids_to_delete = $thisCarts->pluck('id');
        Cart::whereIn('id', $ids_to_delete)->delete();
        return "success";
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('orders.show', ['order' => Order::findOrFail($id)/*, 'quant' => DB::table('order_item')->where('order_id', $id)->get(), 'qBasket' => DB::table('basket_order')->where('order_id', $id)->get()*/]);
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
        $order = Order::findOrFail($id);
        $order->verified_at = now();
        $order->reciever_remark = $request['reciever_remark'];
        $order->save();
        // $response = $this->sendPushNotification($order->reciever_id, $order->sender_id, "User ".User::where('id', $order->reciever_id)->first()->f_name." ".User::where('id', $order->reciever_id)->first()->s_name." verified an order with id ".$order->id.".");

        return redirect('/orders/' . $order->id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Order::findOrFail($id)->items()->detach();
        Order::findOrFail($id)->baskets()->detach();
        Order::findOrFail($id)->delete();
        return redirect('/orders');
        //
    }
    public function cart()
    {
        $baskets = collect(new Basket);
        $carts = Cart::where('sender_id', \Auth::user()->id)->get();
        foreach ($carts as $cart) {
            if ($cart->is_basket) {
                $baskets->push(Basket::findOrFail($cart->item_id));
            }
        }
        return view('orders.cart', ['carts' => $carts, 'baskets' => $baskets]);
    }
    public function addToCart(Request $request)
    {
        $freeQuant = 0;
        $offersAgents = [];
        $reciever = User::findOrFail($request->reciever_id);
        // dd($reciever->category->id);
        $cart = Cart::where(['sender_id' => \Auth::user()->id, 'reciever_id' => $request->reciever_id, 'item_id' => $request->item_id, 'is_basket' => ($request->isBasket == "true")])->get();
        if ($cart->count() == 0) {
            $cart = new Cart([
                'sender_id' => \Auth::user()->id,
                'reciever_id' => $request->reciever_id,
                'item_id' => $request->item_id,
                'remark' => $request->sender_remark,
                'quantity' => $request->quantity,
                'is_basket' => ($request->isBasket == "true")
            ]);
            if ($request->isBasket == "true") {
                try {
                    $price = $request->quantity * (Basket::findOrFail($request->item_id)->price);
                } catch (\Exception $e) {
                    dd($e);
                }
            } else {
                $item = Item::findOrFail($request->item_id);
                if ($request->offer) {
                    $currentOffer = Offer::query()->findOrFail($request->offer);
                    if ($currentOffer->discount > 0 && $request->quantity >= $currentOffer->quant)
                        $item->price -= (float) $item->price * ($currentOffer->discount / 100);
                    if ($currentOffer->free_quant > 0 && $request->quantity >= $currentOffer->quant) {
                        if ($request->item_id == $currentOffer->free_item)
                            $freeQuant = (int) (floor($request->quantity / $currentOffer->quant) * $currentOffer->free_quant);
                    }
                }
                $price = (float) ($request->quantity * $item->price);
            }
            $cart->price = $price;
            $cart->free_quant = $freeQuant;
            $cart->is_basket = ($request->isBasket == "true");
        } else {
            $cart = $cart->first();
            $quantity = $cart->quantity + $request->quantity;
            if ($request->isBasket == "true")
                $price = $quantity * (Basket::findOrFail($request->item_id)->price);
            else {
                $item = Item::findOrFail($request->item_id);
                if ($request->offer) {
                    $currentOffer = Offer::query()->findOrFail($request->offer);
                    if ($currentOffer->discount > 0 && $quantity >= $currentOffer->quant)
                        $item->price -= (float) $item->price * ($currentOffer->discount / 100);
                    if ($currentOffer->free_quant > 0 && $quantity >= $currentOffer->quant) {
                        if ($request->item_id == $currentOffer->free_item)
                            $freeQuant = (int) (floor($quantity / $currentOffer->quant) * $currentOffer->free_quant);
                    }
                }
                $price = $quantity * $item->price;
            }
            $cart->quantity = $quantity;
            $cart->free_quant = $freeQuant;
            $cart->price = $price;
        }
        $cart->save();
        return '';
    }
    public function deleteFromCart($id)
    {
        Cart::findOrFail($id)->delete();

        return redirect('/cart');
    }
    public function editInCart()
    {
        //
    }
    public function postItem(Request $request)
    {
        if ($request->isBasket == "true")
            return Basket::findOrFail($request->id)->user;
        else {
            $item = Item::findOrFail($request->id);

            $allAgents = $item->company->children->filter(function ($value, $key) {
                if (($value['user_category_id'] == Constants::AGENT || $value['user_category_id'] == Constants::FREE_DISTRIBUTOR)) {
                    return true;
                }
            });
            $c = collect();

            foreach ($allAgents as $key => $value) {
                $isFreezed = (bool) (DB::table('user_relations')->where(['child_id' => $value->id, 'parent_id' => $item->company->id])->value('freezed'));
                if ($isFreezed) {
                    $allAgents->forget($key);
                }
            }

            foreach ($allAgents as $agent) {
                $c = $c->concat($agent->children->where('user_category_id', Constants::DISTRIBUTOR));
            }
            $allAgents = $allAgents->concat($c);
            $allAgents = $allAgents->filter(function ($value, $key) {
                if ($value['city'] == \Auth::user()->city) {
                    return true;
                }
            });

            $favAg = \Auth::user()->children()->wherePivot('comp_id', '=', $item->company->id)->get();
            foreach ($allAgents as $key => $value) {
                if ($favAg->contains('id', $value->id))
                    $allAgents->forget($key);
            }
            foreach ($favAg as $fA)
                $allAgents->prepend($fA);

            foreach ($allAgents as $key => $value) {

                if ($item->isFreezedByUser($value->id)) {
                    $allAgents->forget($key);
                }
            }
            // foreach ($allAgents as $key => $value) {
            //     foreach ($non_allowed_ids as $id) {
            //         if ($id->dist_id == $value->id) {
            //             $allAgents->forget($key);
            //         }
            //     }
            // }
        }
        $offersAgents = $allAgents->pluck('id');
        $offersAgents[] = $item->user_id;
        $offerUsers = Offer::where('item_id', $item->id)
            ->whereIn('user_id', $offersAgents)
            ->where('to_date', '>=', now())
            ->where('from_date', '<=', now())
            ->pluck('user_id');
        $offersAgents = User::whereIn('id', $offerUsers)->get();
        $res = ['agents' => $allAgents->unique(), 'offersAgents' => $offersAgents];
        return $res;
    }
    public function postItemAgent(Request $request)
    {
        $item = Item::findOrFail($request->item);
        $reciever = User::findOrFail($request->id);
        $offersAgents = User::where('user_category_id', Constants::ADMIN)->pluck('id')->toArray();
        $offersAgents[] = (int) $request->id;
        $offersAgents[] = (int) $item->user_id;
        $recieverOffersAgents = [];
        // dd($reciever->category->id);
        if ($reciever->category->id != Constants::AGENT) {
            $recieverParents = User::findOrFail($request->id)->parents;
            $recieverOffersAgents = $recieverParents->where('user_category_id', Constants::AGENT)->pluck('id')->toArray();
        }
        $offersAgents = array_merge($offersAgents, $recieverOffersAgents);
        Log::debug($offersAgents);
        $offer = $item->offers
            ->where('to_date', '>=', now())
            ->where('from_date', '<=', now())
            ->whereIn('user_id', $offersAgents);
        return $offer;
    }
    public function verifyItem(Request $request)
    {
        $item = Item::findOrFail($request->item);
        $order = Order::findOrFail($request->order);
        $order->items()->updateExistingPivot($item, array('verified_at' => now(), 'reciever_remark' => $request->remark), false);
        $order->save();
        return "success";
    }
    public function addAllItemsToCart(Request $request)
    {
        // dd($request->objects);
        foreach ($request->objects as $obj) {
            $obj = (object) $obj;
            $freeQuant = 0;
            $cart = Cart::where(['sender_id' => \Auth::user()->id, 'reciever_id' => $obj->reciever, 'item_id' => $obj->id, 'is_basket' => false])->get();
            if ($cart->count() == 0) {
                $cart = new Cart([
                    'sender_id' => \Auth::user()->id,
                    'reciever_id' => $obj->reciever,
                    'item_id' => $obj->id,
                    'remark' => null,
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
                $currentOffers = $item->offers->where('to_date', '>=', now())->where('user_id', $obj->reciever);
                if ($currentOffers->count() > 0 && $currentOffers->where('discount', '>', 0)->count() > 0 && $obj->quant >= $currentOffers->where('discount', '>', 0)->first->quantity) {
                    $item->price -= (float) $item->price * ($currentOffers->where('discount', '>', 0)->first->discount->discount / 100);
                }
                if ($currentOffers->count() > 0 && $currentOffers->where('free_quant', '>', 0)->count() > 0 && $obj->quant >= $currentOffers->where('free_quant', '>', 0)->first->free_quant->quant && $obj->id >= $currentOffers->where('free_quant', '>', 0)->first->free_quant->free_item) {
                    $freeQuant = (int) (($obj->quant / $currentOffers->where('free_quant', '>', 0)->first->free_quant->quant) * $currentOffers->where('free_quant', '>', 0)->first->free_quant->free_quant);
                }
                $price = (float) ($obj->quant * $item->price);
                // }
                $cart->price = $price;
                $cart->free_quant = $freeQuant;
                $cart->is_basket = false;
            } else {
                $cart = $cart->first();
                $quantity = $cart->quantity + $obj->quant;
                $item = Item::findOrFail($obj->id);
                $currentOffers = $item->offers->where('to_date', '>=', now())->where('user_id', $obj->reciever);
                if ($currentOffers->count() > 0 && $currentOffers->where('discount', '>', 0)->count() > 0 && $quantity >= $currentOffers->where('discount', '>', 0)->first->quantity) {
                    $item->price -= $item->price * ($currentOffers->where('discount', '>', 0)->first->discount->discount / 100);
                }
                if ($currentOffers->count() > 0 && $currentOffers->where('free_quant', '>', 0)->count() > 0 && $quantity >= $currentOffers->where('free_quant', '>', 0)->first->free_quant->quant && $obj->id >= $currentOffers->where('free_quant', '>', 0)->first->free_quant->free_item) {
                    $freeQuant = (int) (($quantity / $currentOffers->where('free_quant', '>', 0)->first->free_quant->quant) * $currentOffers->where('free_quant', '>', 0)->first->free_quant->free_quant);
                }
                $price = $quantity * $item->price;

                $cart->quantity = $quantity;
                $cart->free_quant = $freeQuant;
                $cart->price = $price;
            }
            $cart->save();
        }
        return "success";
    }
}
