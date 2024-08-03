<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Seller\SellerResource;
use App\Models\Buyer;

class BuyerSellerController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $this->allowedAdminActions();
        $sellers = $buyer->transactions()
        ->with('product.seller')
        ->get()
        ->pluck('product.seller');

        $sellers = SellerResource::collection($sellers);

        return $this->showAll($sellers, 200);
    }

}
