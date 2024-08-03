<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Seller;

class SellerTransactionController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
        $this->middleware('can:view,seller')->only('index');
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

        $transactions = TransactionResource::collection($transactions);
        return $this->showAll($transactions, 200);
    }

}
