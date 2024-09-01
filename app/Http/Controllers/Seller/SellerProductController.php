<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\Product\ProductResource;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    public function __construct() {
        $this->middleware('can:view,seller')->only('index');
        $this->middleware('can:edit-product,seller')->only('update');
        $this->middleware('can:delete-product,seller')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        foreach($products as $product) {
            $product->image = $product->image ? url('storage/products/' . $product->image) : null;
        }

        $products = ProductResource::collection($products);
        return $this->showAll($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request, User $seller)
    {
        if ($this->authorize('saleProduct', $seller)) {
            $data = $request->validated();
    
            $data['seller_id'] = $seller->id;
    
            if ($request->hasFile('image')) {
                $data['image'] = $this->storeImage($request, $request->image, 'products');
            }
    
            $product = Product::create($data);
        }

        $product = new ProductResource($product);
        return $this->showOne($product, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductUpdateRequest $request, Seller $seller, Product $product)
    {
        $request->validated();

        $this->checkSeller($seller, $product);

        $product->fill(array_filter($request->only([
            'name',
            'description',
            'quantity',
        ])));

        if ($request->has('status')) {
            $product->status = $request->status;
            if ($product->isAvailable() && $product->categories()->count() == 0) {
                return $this->errorResponse('An unavailable product must have at least one category', 409);
            }
        }

        if ($request->hasFile('image')) {
            if (Storage::exists('public/products/' . $product->image)) {
                Storage::delete('public/products/' . $product->image);
            }

            $product->image = $this->storeImage($request, $request->image, 'products');
        }

        if ($product->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $product->save();

        $product = new ProductResource($product);
        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();
        if (Storage::exists('public/products/' . $product->image)) {
            Storage::delete('public/products/' . $product->image);
        }

        $product = new ProductResource($product);
        return $this->showOne($product);
    }

    protected function checkSeller(Seller $seller, Product $product) {
        if ($product->seller_id !== $seller->id || $product->seller_id != $seller->id) {
            throw new HttpException(409, 'The specified product is not owned by the specified seller or the seller does not have this product');
        }
    }
}
