<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Product;

class ProductTransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only('index');
        $this->middleware('can:view,product')->only('index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Product $product)
    {
        $this->allowedAdminActions();
        $transactions = $product->transactions;

        $transactions = TransactionResource::collection($transactions);
        return $this->showAll($transactions, 200);
    }

}
