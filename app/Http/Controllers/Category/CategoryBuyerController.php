<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryBuyerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $buyers = $category->products()
        ->with('transactions.buyer')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->pluck('buyer')
        ->unique('id')
        ->values();

        return $this->showAll(new Collection($buyers), 200);
    }

}
