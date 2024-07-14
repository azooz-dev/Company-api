<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryBuyerController extends ApiController
{

    public function __construct() {
        $this->middleware('auth:api')->only(['index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $this->allowedAdminActions();
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
