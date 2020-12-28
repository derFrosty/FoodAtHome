<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewOrderRequest;
use App\Models\Order;
use App\Models\Order_Item;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function confirmOrder(NewOrderRequest $request)
    {
        $products = $request['products'];
        $orderNotes = $request['orderNotes'];

        DB::transaction(function () use ($orderNotes, $products) {

            $total_sum = 0;

            //calculate total price
            foreach ($products as $product) {

                //verify if product id really exists in DB, if it doesn't client should receive an exception
                $p = Product::findOrFail($product['id']);

                $total_sum += $p['price'] * $p['quantity'];

            }

            $user_id = Auth::id();
            $date = Carbon::now();

            $order = new Order;

            $order->status = 'H';
            $order->customer_id = $user_id;
            $order->notes = $orderNotes;
            $order->total_price = $total_sum;
            $order->date = $date->format('Y-m-d');
            $order->prepared_by = null;
            $order->delivered_by = null;
            $order->opened_at = $date->toDateTimeString();
            $order->current_status_at = $date->toDateTimeString();
            $order->closed_at = null;
            $order->preparation_time = null;
            $order->delivery_time = null;
            $order->total_time = null;

            $order->save();

            foreach ($products as $product){

                $order_item = new Order_Item;

                $order_item->order_id = $order->id;
                $order_item->product_id = $product['id'];
                $order_item->quantity = $product['quantity'];

                $unit_price = Product::find($product['id'])['price'];

                $order_item->unit_price = $unit_price;
                $order_item->sub_total_price = $unit_price * $product['quantity'];

                $order_item->save();

            }


        });

        return response()->json(
            ['msg' => 'Order was completed'],
            200
        );
    }
}
