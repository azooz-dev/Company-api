<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Buyer;

class BuyerCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->only(['index']);
        $this->middleware('can:view,buyer')->only('index');
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

        $categories = CategoryResource::collection($categories);

        return $this->showAll($categories, 200);
    }

}
