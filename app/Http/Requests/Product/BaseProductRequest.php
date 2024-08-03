<?php

namespace App\Http\Requests\Product;

use App\Http\Requests\BaseRequest;

abstract class BaseProductRequest extends BaseRequest
{
    // Define the common validation rules to be implemented by ProductStoreRequest & ProductUpdateRequest classes 
    public abstract function rules(): array;

    // Common attribute names for products
    public function attributes(): array {
        return [
            'name'        => 'title',
            'description' => 'details',
            'quantity'    => 'quantity',
            'image'       => 'image',
            'status'      => 'stock',
        ];
    }

    // Common transformation of attributes for products
    public static function transformAttributes($index) {
        $attribute = [
            'title'    => 'name',
            'details'  => 'description',
            'quantity' => 'quantity',
            'image'    => 'image',
            'stock'    => 'status',
        ];

        return $attribute[$index] ? $attribute[$index] : null;
    }
}
