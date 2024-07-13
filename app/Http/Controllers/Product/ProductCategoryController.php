<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCategoryController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api')->except(['index']);
    }
    /**
     * Display a listing of the resource.
    */
    public function index(Product $product)
    {
        $categories = $product->categories;

        return $this->showAll($categories, 200);
    }

    /**
     * Update the specified resource in storage.
    */
    public function update(Request $request, Product $product, Category $category)
    {
        $product->categories()->syncWithoutDetaching([$category->id]);

        return $this->showAll($product->categories, 200);
    }

    /**
     * Remove the specified resource from storage.
    */
    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('The category does not belong to this product', 409);
        }

        $product = $product->categories()->detach([$category->id]);

        return $this->showOne($category);
    }
}
