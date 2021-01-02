<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CookApiController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user['type'] != 'EC'){
            abort(403);
        }

        //null == cook is preparing something
        if (!$user['available_at']){

            $order = Order::Where('prepared_by', $user['id'])->Where('status', 'P')->first();

            $order_items = Order_Item::Where('order_id',$order['id'])->get();

            dd($order_items);

        }

        return 'boas';
    }
}
