<?php

namespace App\Transformers\Transaction;

use App\Models\Transaction;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
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
    public function transform(Transaction $transaction)
    {
        return [
            'identifier' => (int) $transaction->id,
            'quantity'   => (int) $transaction->quantity,
            'product'    => (int) $transaction->product_id,
            'buyer'      => (int) $transaction->buyer_id,
            'createDate' => (string) $transaction->created_at,
            'lastChange' => (string) $transaction->updated_at,
            'deletedDate' => (string) ($transaction->deleted_at ? $transaction->deleted_at : null),
            'links' => [
                [
                    'rel'  => 'self',
                    'href' => route('transactions.show', $transaction->id),
                ],
                [
                    'rel'  => 'transaction.sellers',
                    'href' => route('transactions.sellers.index', $transaction->id),
                ],
                [
                    'rel'  => 'transactions.categories',
                    'href' => route('transactions.categories.index', $transaction->id),
                ],
                [
                    'rel'  => 'buyer',
                    'href' => route('buyers.show', $transaction->buyer_id),
                ],
                [
                    'rel'  => 'product',
                    'href' => route('products.show', $transaction->product_id),
                ],
            ]
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'  => 'id',
            'quantity'    => 'quantity',
            'product'     => 'product_id',
            'buyer'       => 'buyer_id',
            'createDate'  => 'created_at',
            'lastChange'  => 'updated_at',
            'deletedDate' => 'deleted_at',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }

    public static function transformAttribute($index) {
        $attributes = [
            'id'         => 'identifier',
            'quantity'   => 'quantity',
            'product_id' => 'product',
            'buyer_id'   => 'buyer',
            'created_at' => 'createDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
