<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Models\Buyer;
use Illuminate\Database\Eloquent\Collection;

class BuyerCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Buyer $buyer)
    {
        $categories = $buyer->transactions()
        ->with('product.categories')
        ->get()
        ->pluck('product.categories')
        ->flatten()
        ->unique('id')
        ->values();

        return $this->showAll(new Collection($categories), 200);
    }

}
