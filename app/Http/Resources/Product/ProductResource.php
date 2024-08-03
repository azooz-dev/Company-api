<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier'  => (int) $this->id,
            'title'       => (string) $this->name,
            'details'     => (string) $this->description,
            'quantity'    => (int) $this->quantity,
            'stock'       => (string) $this->status,
            'image'       => Storage::url('public/products/' . $this->image),
            'seller'      => (int) $this->seller_id,
            'createdData' => (string) $this->created_at,
            'lastChange'  => (string) $this->updated_at,
            'deleted_at'  => (string) $this->deleted_at ? $this->deleted_at : null,
            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('products.show', $this->id),
                ],
                [
                    'rel'  => 'product.transactions',
                    'href' => route('products.transactions.index', $this->id),
                ],
                [
                    'rel'  => 'product.buyers',
                    'href' => route('products.buyers.index', $this->id),
                ],
                [
                    'rel'  => 'product.categories',
                    'href' => route('products.categories.index', $this->id),
                ],
                [
                    'rel'  => 'Seller',
                    'href' => route('sellers.show', $this->seller_id),
                ],
            ]
        ];
    }

    public static function transformAttribute($index) {
        $attributes = [
            'identifier'  => 'id',
            'title'       => 'name',
            'details'     => 'description',
            'quantity'    => 'quantity',
            'stock'       => 'status',
            'image'       => 'image',
            'seller'      => 'seller_id',
            'createDate'  => 'created_at',
            'lastChange'  => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
