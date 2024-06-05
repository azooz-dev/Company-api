<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use \Illuminate\Database\Eloquent\Collection;
use App\Models\Buyer;

class BuyerProductController extends ApiController
{
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
