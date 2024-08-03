<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Buyer\BuyerResource;
use App\Models\Product;

class ProductBuyerController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only('index');
        $this->middleware('can:view,product')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $this->allowedAdminActions();
        $buyers = $product->transactions()
        ->get()
        ->map(function ($transaction) {
            return $transaction->buyer;
        });

        $buyers = BuyerResource::collection($buyers);

        return $this->showAll($buyers, 200);
    }

}
