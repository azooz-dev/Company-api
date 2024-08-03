<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Category\CategoryStoreRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Http\Resources\Category\CategoryResource;
use App\Models\Category;

class CategoryController extends ApiController
{
    public function __construct() {
        $this->middleware('auth:api')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();

        $categories = CategoryResource::collection($categories);
        return $this->showAll($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $this->allowedAdminActions();
        $request->validated();

        $category = Category::create($request->only(['title', 'details']));

        $category = new CategoryResource($category);
        return $this->showOne($category, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category = new CategoryResource($category);
        return $this->showOne($category, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateRequest $request, Category $category)
    {
        $this->allowedAdminActions();
        $category->fill($request->only([
            'name',
            'description'
        ]));

        if ($category->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $category->save();
        $category = new CategoryResource($category);
        return $this->showOne($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->allowedAdminActions();
        $category->delete();

        $category = new CategoryResource($category);
        return $this->showOne($category);
    }
}
