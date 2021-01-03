<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductValidationForm;
use App\Http\Requests\UpdateUserValidationForm;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('page')) {
            return ProductResource::collection(Product::paginate(5));
        } else {
            return ProductResource::collection(Product::all());
        }
    }

    public function getTypes(){
        return DB::table('products')->select('type')->distinct()->get();
    }

    public function addProduct(ProductValidationForm $request){

        $photo = $request->file('photo_url');

        $registration = $request->only('name', 'type', 'description', 'photo_url', 'price');



        $filename = Storage::putFileAs('public/products', $request->photo_url, time() . '.' . $photo->getClientOriginalExtension());

        $filename = substr($filename, strrpos($filename, '/')+1, strlen($filename));


        $transation_result = DB::transaction(function () use ($filename, $registration) {
            $product = Product::create([
                'name' => $registration["name"],
                'type' => $registration["type"],
                'description' => $registration["description"],
                'photo_url' => $filename,
                'price' => $registration["price"],
            ]);


        });



        return response()->json(
            ['msg' => 'product created with success.'],
            200
        );
    }
}
