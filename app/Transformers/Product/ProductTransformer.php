<?php

namespace App\Transformers\Product;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use League\Fractal\TransformerAbstract;

class ProductTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected array $defaultIncludes = [
        //
    ];
    
    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected array $availableIncludes = [
        //
    ];
    
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Product $product)
    {
        return [
            'identifier'   => (int) $product->id,
            'title'        => (string) $product->name,
            'details'      => (string) $product->description,
            'quantity'     => (int) $product->quantity,
            'stock'        => (string) $product->status,
            'image'        => Storage::url('public/products/' . $product->image),
            'seller'       => (int) $product->seller_id,
            'creationDate' => (string) $product->created_at,
            'lastChange'   => (string) $product->updated_at,
            'deletedDate'  => (string) ($product->deleted_at ? $product->deleted_at : null),
            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('products.show', $product->id),
                ],
                [
                    'rel'  => 'product.transactions',
                    'href' => route('products.transactions.index', $product->id),
                ],
                [
                    'rel'  => 'product.buyers',
                    'href' => route('products.buyers.index', $product->id),
                ],
                [
                    'rel'  => 'product.categories',
                    'href' => route('products.categories.index', $product->id),
                ],
                [
                    'rel'  => 'Seller',
                    'href' => route('sellers.show', $product->seller_id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
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

    public static function transformAttribute($index) {
        $attributes = [
            'id'          => 'identifier',
            'name'        => 'title',
            'description' => 'details',
            'quantity'    => 'quantity',
            'status'      => 'stock',
            'image'       => 'image',
            'seller_id'   => 'seller',
            'created_at'  => 'createDate',
            'updated_at'  => 'lastChange',
            'deleted_at'  => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}