<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\ApiController;
use App\Models\Product;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\HttpException;

class SellerProductController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Seller $seller)
    {
        $products = $seller->products;

        foreach($products as $product) {
            $product->image = $product->image ? url('storage/products/' . $product->image) : null;
        }

        return $this->showAll($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $seller)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required',
            'quantity' => 'required|integer|min:1',
            'image' => 'sometimes|image',
            'status' => 'in:' . Product::AVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT
        ]);

        $data['seller_id'] = $seller->id;

        if ($request->hasFile('image')) {
            $data['image'] = $this->storeImage($request, $request->image, 'products');
        }

        $product = Product::create($data);

        return $this->showOne($product, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seller $seller, Product $product)
    {
        $request->validate([
            'quantity' => 'integer|min:1',
            'image' => 'image'
        ]);

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
            if (Storage::exists('products/' . $product->image)) {
                Storage::delete('products/' . $product->image);
            }

            $product->image = $this->storeImage($request, $request->image, 'products');
        }

        if ($product->isClean()) {
            return $this->errorResponse('You need to specify a different value to update', 422);
        }

        $product->save();

        return $this->showOne($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Seller $seller, Product $product)
    {
        $this->checkSeller($seller, $product);

        $product->delete();

        return $this->showOne($product);
    }

    protected function checkSeller(Seller $seller, Product $product) {
        if ($product->seller_id !== $seller->id || $product->seller_id != $seller->id) {
            throw new HttpException(409, 'The specified product is not owned by the specified seller or the seller does not have this product');
        }
    }
}
