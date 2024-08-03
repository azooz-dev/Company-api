<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Seller\SellerResource;
use App\Models\Transaction;

class TransactionSellerController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['index']);
        $this->middleware('can:see,transaction')->only('index');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        $seller = $transaction->product->seller;

        $seller = new SellerResource($seller);
        return $this->showOne($seller, 200);
    }

}
