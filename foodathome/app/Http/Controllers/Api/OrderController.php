<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type != 'C'){
            abort(403);
        }

        if ($request->has('page')) {
            return OrderResource::collection(Order::paginate(5));
        } else {
            return OrderResource::collection(Order::all());
        }
    }

    public function myOrders(Request $request)
    {
        if (Auth::user()->type != 'C'){
            abort(403);
        }

        if ($request->has('page')) {
            return OrderResource::collection(
                Order::whereIn('status', ['H', 'P', 'R', 'T'])
                ->where('customer_id', Auth::id())
                ->paginate(5));
        } else {
            return OrderResource::collection(
                Order::whereIn('status', ['H', 'P', 'R', 'T'])
                ->where('customer_id', Auth::id())
                ->get());
        }
    }

    public function orderHistory(Request $request)
    {
        if (Auth::user()->type != 'C'){
            abort(403);
        }

        if ($request->has('page')) {
            return OrderResource::collection(
                Order::whereIn('status', ['D', 'C'])
                ->where('customer_id', '=', Auth::user()->id)
                ->paginate(5));
        } else {
            return OrderResource::collection(
                Order::whereIn('status', ['D', 'C'])
                ->where('customer_id', '=', Auth::user()->id)
                ->get());
        }
    }
}
