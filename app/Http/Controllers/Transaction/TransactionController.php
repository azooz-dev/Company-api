<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Transaction;

class TransactionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['index', 'show']);
        $this->middleware('can:see,transaction')->only('show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->allowedAdminActions();
        $transactions = Transaction::all();

        $transactions = TransactionResource::collection($transactions);
        return $this->showAll($transactions, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction = new TransactionResource($transaction);
        return $this->showOne($transaction, 200);
    }
}
