<?php

namespace App\Http\Requests\Transaction;

use App\Http\Requests\BaseRequest;

abstract class BaseTransactionRequest extends BaseRequest
{
    // Define the common validation rules to be implemented by TransactionStoreRequest class
    public abstract function rules(): array;

    // Common attribute names for transaction
    public function attributes(): array {
        return [
            'id'       => 'identifier',
            'quantity' => 'quantity',
            'buyer'    => 'buyer',
            'product'  => 'product',
        ];
    }

    // Common transformation of attributes for transaction
    public static function transformAttributes($index) {
        $attribute = [
            'id'       => 'identifier',
            'quantity' => 'quantity',
            'buyer'    => 'buyer_id',
            'product'  => 'product_id',
        ];
        return $attribute[$index] ? $attribute[$index] : null;
    }
}
