<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Order_Item;
use App\Models\Product;
use App\Models\User;
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
        if (!$user['available_at'] && $user['logged_at']){

            $order = Order::Where('prepared_by', $user['id'])->Where('status', 'P')->first();

            $order_items = Order_Item::Where('order_id',$order['id'])->get();

            $customer = User::find($order['customer_id']);

            $preparing_order = [];
            $preparing_order['customer']['id'] = $customer['id'];
            $preparing_order['customer']['name'] = $customer['name'];

            $preparing_order['order'] = $order;
            $preparing_order['order_items'] = $order_items;

            foreach ($preparing_order['order_items'] as $key => $item){
                $product = Product::find($item['product_id']);

                $preparing_order['order_items'][$key]['name'] = $product['name'];
                $preparing_order['order_items'][$key]['photo_url'] = $product['photo_url'];
            }

            return response()->json(
                [
                    'msg' => 'true',
                    'preparing_order' => $preparing_order
                ],
                200
            );

        }

        return response()->json(
            [
                'msg' => 'false',
                'preparing_order' => []
            ],
            200
        );
    }
}
