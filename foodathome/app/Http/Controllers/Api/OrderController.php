<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PrepareOrderRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderResourceWithRelations;
use App\Http\Resources\ProductResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type != 'C') {
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
        if (Auth::user()->type != 'C') {
            abort(403);
        }

        if ($request->has('page')) {
            return OrderResourceWithRelations::collection(
                Order::whereIn('status', ['H', 'P', 'R', 'T'])
                    ->where('customer_id', Auth::id())
                    ->paginate(5));
        } else {
            return OrderResourceWithRelations::collection(
                Order::whereIn('status', ['H', 'P', 'R', 'T'])
                    ->where('customer_id', Auth::id())
                    ->get());
        }
    }

    public function orderHistory(Request $request)
    {
        if (Auth::user()->type != 'C') {
            abort(403);
        }

        if ($request->has('page')) {
            return OrderResourceWithRelations::collection(
                Order::whereIn('status', ['D', 'C'])
                    ->where('customer_id', Auth::id())
                    ->paginate(5));
        } else {
            return OrderResourceWithRelations::collection(
                Order::whereIn('status', ['D', 'C'])
                    ->where('customer_id', Auth::id())
                    ->get());
        }
    }

    public function activeOrders(Request $request)
    {
        if (Auth::user()->type != 'EM') {
            abort(403);
        }

        if ($request->has('page')) {
            return OrderResourceWithRelations::collection(
                Order::whereIn('status', ['H', 'P', 'R', 'T'])->paginate(5));
        } else {
            return OrderResourceWithRelations::collection(
                Order::whereIn('status', ['H', 'P', 'R', 'T'])->get());
        }
    }

    public function getProducts($idOrder)
    {
        $order_items = Order::findOrFail($idOrder)->order_items;
        $products = [];

        foreach ($order_items as $order_item) {
            array_push($products, Product::findOrFail($order_item->product_id));
        }

        return $products;
    }

    public function getReadyOrders()
    {
        return OrderResourceWithRelations::collection(Order::orderBy('current_status_at', 'ASC')->Where('status', 'R')->get());
    }

    public function getOrderCurrentlyDelivering(){
        return OrderResourceWithRelations::collection(Order::Where('status', 'T')->Where('delivered_by', Auth::id())->get());
    }

    public function assignOrderToDeliver(Request $request){
        if(!$request->order_id){
            return response()->json(
                ['msg' => 'Missing argument order_id'],
                422
            );
        }

        $order = Order::Where('id', $request->order_id)->first();

        $order->delivered_by = Auth::id();
        $order->status = 'T';

        $order->save();

        return response()->json(
            ['msg' => 'Successfully assigned order to deliver.',
                'order' => OrderResourceWithRelations::collection(Order::Where('status', 'T')->Where('delivered_by', Auth::id())->get())],
            200
        );

    }

    public function orderDelivered (){
        $order = Order::Where('status', 'T')->Where('delivered_by', Auth::id())->first();

        $order->status = 'D';

        $order->save();

    }

    public function orderPrepared(PrepareOrderRequest $request){
        $user = Auth::user();

        if(!$user || $user->type != 'EC'){
            abort(403);
        }

        $order = Order::find($request['id']);
        $order->status = 'R';
        $order->save();

        $checkIfHasOrder = Order::Where('prepared_by', $user['id'])->where('status','P')->count();

        return response()->json(
            ['msg' => 'Successfully prepared order.', 'order' => $order['id'], 'hasOrder' => $checkIfHasOrder],
            200
        );
    }

    public function orderCancel($idOrder){
        if (Auth::user()->type != 'EM') {
            abort(403);
        }

        $order = Order::findOrFail($idOrder);

        $order->status = 'C';

        $order->save();
    }
}

