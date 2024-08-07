<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Product\ProductResource;
use App\Models\Buyer;

class BuyerProductController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
        $this->middleware('can:view,buyer')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()
            ->with('product')
            ->get()
            ->pluck('product');

        $products = ProductResource::collection($products);

        return $this->showAll($products, 200);
    }

}
