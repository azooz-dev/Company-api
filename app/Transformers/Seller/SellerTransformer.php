<?php

namespace App\Transformers\Seller;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier'   => (int) $seller->id,
            'name'         => (string) $seller->name,
            'email'        => (string) $seller->email,
            'isVerified'   => (int) $seller->verified,
            'creationDate' => (string) $seller->created_at,
            'lastChange'   => (string) $seller->updated_at,
            'deletedDate'  => (string) ($seller->deleted_at ? $seller->deleted_at : null),
            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('sellers.show', $seller->id)
                ],
                [
                    'rel'  => 'seller.buyers',
                    'href' => route('sellers.buyers.index', $seller->id)
                ],
                [
                    'rel'  => 'seller.categories',
                    'href' => route('sellers.categories.index', $seller->id)
                ],
                [
                    'rel'  => 'seller.products',
                    'href' => route('sellers.products.index', $seller->id)
                ],
                [
                    'rel'  => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $seller->id)
                ],
                [
                    'rel'  => 'seller.profile',
                    'href' => route('users.show', $seller->id)
                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'  => 'id',
            'name'        => 'name',
            'email'       => 'email',
            'isVerified'  => 'verified',
            'createDate'  => 'created_at',
            'lastChange'  => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformAttribute($index) {
        $attributes = [
            'id'         => 'identifier',
            'name'       => 'name',
            'email'      => 'email',
            'verified'   => 'isVerified',
            'created_at' => 'createDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
