<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;

class CategoryProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $products = $category->products()->get()->makeHidden('pivot');

        return $this->showAll($products, 200);
    }

}
