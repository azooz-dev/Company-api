<?php

namespace App\Transformers\Buyer;

use App\Models\Buyer;
use League\Fractal\TransformerAbstract;

class BuyerTransformer extends TransformerAbstract
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
    public function transform(Buyer $buyer)
    {
        return [
            'identifier'   => (int) $buyer->id,
            'name'         => (string) $buyer->name,
            'email'        => (string) $buyer->email,
            'isVerified'   => (int) $buyer->verified,
            'creationDate' => (string) $buyer->created_at,
            'lastChange'   => (string) $buyer->updated_at,
            'deletedDate'  => (string) $buyer->deleted_at ? $buyer->deleted_at : null,
            'links'        => [
                [
                    'rel'  => 'self',
                    'href' => route('buyers.show', $buyer->id),
                ],
                [
                    'rel'  => 'buyer.categories',
                    'href' => route('buyers.categories.index', $buyer->id),
                ],
                [
                    'rel'  => 'buyer.products',
                    'href' => route('buyers.products.index', $buyer->id),
                ],
                [
                    'rel'  => 'buyer.transactions',
                    'href' => route('buyers.transactions.index', $buyer->id),
                ],
                [
                    'rel'  => 'buyer.profile',
                    'href' => route('users.show', $buyer->id),
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
