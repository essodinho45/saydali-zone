<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\User;

class ReportsController extends Controller
{
    //
    public function ordersReport()
    {
        $agents = User::whereIn('user_category_id', [2, 3, 4])->get();

        if (\Auth::user()->category->id == 6)
            $orders = Order::all();
        elseif (\Auth::user()->category->id == 2) {
            $recievers = \Auth::user()->children->pluck('id')->toArray();
            array_push($recievers, \Auth::user()->id);
            $orders = Order::whereIn('reciever_id', $recievers)
                ->get();

            $agents = \Auth::user()->children;
        } elseif (\Auth::user()->category->id == 3 || \Auth::user()->category()->id == 4)
            $orders = Order::where('reciever_id', \Auth::user()->id)->get();
        elseif (\Auth::user()->category->id == 1) {
            $agents = \Auth::user()->children;
            foreach ($agents as $agent) {
                foreach ($agent->children as $child) {
                    if (User::where('id', '=', $child->id)->count() == 0)
                        $agents->push($child);
                }
            }
        }

        return view('reports.orders', ['orders' => $orders, 'agents' => $agents]);
    }

    public function updateOrdersReport(Request $request)
    {
        $from_date = $request->from_date ?? new \DateTime('1900-01-01T00:00:00');
        $to_date = $request->to_date ?? now();

        // dd($request->from_date, $request->to_date);

        if (\Auth::user()->category->id == 6) {
            $agents = null;
            if (User::findOrFail($request->agent)->category->id != 2)
                $orders = Order::where('reciever_id', $request->agent)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();
            else {
                $recievers = User::findOrFail($request->agent)->children->pluck('id')->toArray();
                array_push($recievers, $request->agent);
                $orders = Order::whereIn('reciever_id', $recievers)
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->get();
            }
            $agents = User::whereIn('user_category_id', [2, 3, 4])->get();
        } elseif (\Auth::user()->category->id == 3 || \Auth::user()->category->id == 4)
            $orders = Order::where('reciever_id', \Auth::user()->id)
                ->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date)->get();
        elseif (\Auth::user()->category->id == 2) {
            $orders = Order::where('reciever_id', $request->agent)
                ->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date)
                ->get();
            $agents = \Auth::user()->children;
        }

        return view('reports.orders', ['orders' => $orders, 'agents' => $agents]);
    }
}
