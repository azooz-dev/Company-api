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
            'buyer'      => (int) $transaction->buyer_id
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
}
