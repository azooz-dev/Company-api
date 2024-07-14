<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Models\Transaction;

class TransactionCategoryController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Transaction $transaction)
    {
        $this->allowedAdminActions();
        $categories = $transaction->product->categories;

        return $this->showAll($categories, 200);
    }

}
