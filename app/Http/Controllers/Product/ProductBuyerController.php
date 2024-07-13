<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
class ProductBuyerController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $buyers = $product->transactions()
        ->get()
        ->map(function ($transaction) {
            return $transaction->buyer;
        });

        return $this->showAll(new Collection($buyers), 200);
    }

}
