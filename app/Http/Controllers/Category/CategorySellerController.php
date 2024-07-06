<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategorySellerController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $sellers = $category->products()
        ->with('seller')
        ->get()
        ->pluck('seller')
        ->unique('id')
        ->values();

        return $this->showAll(new Collection($sellers), 200);
    }

}
