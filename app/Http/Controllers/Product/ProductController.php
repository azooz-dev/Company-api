<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;

class ProductController extends ApiController
{
    public function __construct()
    {
        $this->middleware('can:view,product')->only('show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        $products = ProductResource::collection($products);
        return $this->showAll($products, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = new ProductResource($product);
        return $this->showOne($product, 200);
    }

}
