<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
class ProductBuyerController extends ApiController
{
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
