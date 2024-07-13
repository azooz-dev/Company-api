<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Database\Eloquent\Collection;

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
        $sellers = $buyer->transactions()
        ->with('product.seller')
        ->get()
        ->pluck('product.seller');

        return $this->showAll(new Collection($sellers), 200);
    }

}
