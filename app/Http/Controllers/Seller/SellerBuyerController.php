<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Buyer\BuyerResource;
use App\Models\Seller;

class SellerBuyerController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $this->allowedAdminActions();
        $buyers = $seller->products()
        ->with('transactions')
        ->get()
        ->flatMap(function ($product) {
            return $product->transactions;
        })
        ->map(function ($transaction) {
            return $transaction->buyer;
        })
        ->unique('id')
        ->values();

        $buyers = BuyerResource::collection($buyers);
        return $this->showAll($buyers, 200);
    }

}
