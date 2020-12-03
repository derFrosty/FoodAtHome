<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return OrderResource::collection(Order::paginate(5));
        } else {
            return OrderResource::collection(Order::all());
        }
    }

    public function myOrders(Request $request)
    {
        if ($request->has('page')) {
            return OrderResource::collection(Order::whereIn('status', ['H', 'P', 'R', 'T'])->paginate(5));
        } else {
            return OrderResource::collection(Order::whereIn('status', ['H', 'P', 'R', 'T'])->get());
        }
    }

    public function orderHistory(Request $request)
    {
        if ($request->has('page')) {
            return OrderResource::collection(Order::whereIn('status', ['D', 'C'])->paginate(5));
        } else {
            return OrderResource::collection(Order::whereIn('status', ['D', 'C'])->get());
        }
    }
}
