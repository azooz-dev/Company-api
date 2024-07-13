<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

class SellerTransactionController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $transactions = $seller->products()
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->unique('id')
        ->values();
        return $this->showAll(new Collection($transactions), 200);
    }

}
