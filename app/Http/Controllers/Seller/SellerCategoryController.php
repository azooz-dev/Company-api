<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Collection;

class SellerCategoryController extends ApiController
{
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

        return $this->showAll(new Collection($categories), 200);

    }

}
