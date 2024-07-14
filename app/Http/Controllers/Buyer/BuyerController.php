<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;

class BuyerController extends ApiController
{
    public function __construct() {
        $this->middleware('auth:api')->only(['index', 'show']);
        $this->middleware('can:view,buyer')->only('show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->allowedAdminActions();
        $buyers = Buyer::has('transactions')->get();

        return $this->showAll($buyers, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Buyer $buyer)
    {
        return $this->showOne($buyer, 200);
    }
}
