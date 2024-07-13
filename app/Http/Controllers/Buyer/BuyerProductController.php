<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\Buyer;

class BuyerProductController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
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

        return $this->showAll(new Collection($products), 200);
    }

}
