<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Seller;

class SellerCategoryController extends ApiController
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
        $categories = $seller->products()
            ->with('categories')
            ->get()
            ->flatMap(function ($product) {
                return $product->categories;
            })
            ->unique('id')
            ->values();

        $categories = CategoryResource::collection($categories);
        return $this->showAll($categories, 200);
    }

}
