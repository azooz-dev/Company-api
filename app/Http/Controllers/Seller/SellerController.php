<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerController extends ApiController
{

    public function __construct()  {
        $this->middleware('auth:api')->only(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = Seller::has('products')->get();

        return $this->showAll($sellers, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        return $this->showOne($seller, 200);
    }
}
