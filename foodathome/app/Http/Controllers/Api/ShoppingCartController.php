<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewOrderRequest;

class ShoppingCartController extends Controller
{
    public function confirmOrder(NewOrderRequest $request){
        $products = $request['products'];
        $orderNotes = $request['orderNotes'];

        DB::transaction(function () use ($products) {

            foreach ($products as $product){



            }



        });

        return $request->validated();
    }
}
