<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

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

        return $this->showAll(new Collection($buyers), 200);
    }

}
