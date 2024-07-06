<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryTransactionController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Category $category)
    {
        $transactions = $category->products()
        ->with('transactions')
        ->get()
        ->pluck('transactions')
        ->collapse()
        ->unique('id')
        ->values();

        return $this->showAll(new Collection($transactions), 200);
    }

}
