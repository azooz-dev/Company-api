<?php

namespace App\Http\Requests\Product;

use App\Models\Product;

class ProductUpdateRequest extends BaseProductRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'        => 'sometimes|string|max:50',
            'description' => 'sometimes|string',
            'quantity'    => 'sometimes|integer|min:1',
            'image'       => 'sometimes|image',
            'status'      => 'in:' . Product::AVAILABLE_PRODUCT . ',' . Product::UNAVAILABLE_PRODUCT
        ];
    }
}
