<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Seller\SellerResource;
use App\Models\Seller;

class SellerController extends ApiController
{

    public function __construct()  {
        $this->middleware('auth:api')->only(['index', 'show']);
        $this->middleware('can:view,seller')->only('show');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->allowedAdminActions();
        $sellers = Seller::has('products')->get();

        $sellers = SellerResource::collection($sellers);
        return $this->showAll($sellers, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Seller $seller)
    {
        $seller = new SellerResource($seller);
        return $this->showOne($seller, 200);
    }
}
