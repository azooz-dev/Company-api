<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

class SellerBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
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

        return $this->showAll(new Collection($buyers), 200);
    }

}
