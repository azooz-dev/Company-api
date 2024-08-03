<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier' => (int) $this->id,
            'quantity'       => (int) $this->quantity,
            'product'        => (int) $this->product_id,
            'buyer'          => (int) $this->buyer_id,
            'createDate'     => (string) $this->created_at,
            'lastChange'     => (string) $this->updated_at,
            'deletedDate'    => (string) $this->deleted_at ? $this->deleted_at : null,
            'links' => [
                [
                    'rel'  => 'self',
                    'href' => route('transactions.show', $this->id),
                ],
                [
                    'rel'  => 'transaction.sellers',
                    'href' => route('transactions.sellers.index', $this->id),
                ],
                [
                    'rel'  => 'transactions.categories',
                    'href' => route('transactions.categories.index', $this->id),
                ],
                [
                    'rel'  => 'buyer',
                    'href' => route('buyers.show', $this->buyer_id),
                ],
                [
                    'rel'  => 'product',
                    'href' => route('products.show', $this->product_id),
                ],
            ]
        ];
    }


    public static function transformAttribute($index) {
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
