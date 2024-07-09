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
            'deletedDate'  => (string) ($product->deleted_at ? $product->deleted_at : null)
        ];
    }
}
