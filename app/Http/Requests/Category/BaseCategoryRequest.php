<?php

namespace App\Http\Requests\Category;

use App\Http\Requests\BaseRequest;

abstract class BaseCategoryRequest extends BaseRequest
{

    // Define the common validation rules to be implemented by CategoryStoreRequest & CategoryUpdateRequest classes
    public abstract function rules(): array;

    // Common attribute names for categories
    public function attributes(): array {
        return [
            'id'          => 'identifier',
            'name'        => 'title',
            'description' => 'details',
            'created_at'  => 'createdDate',
            'updated_at'  => 'lastChange',
            'deleted_at'  => 'deletedDate',
        ];
    }

    // Common transformation of attributes for categories
    public static function transformAttributes($index) {
        $attribute = [
            'title'    => 'name',
            'details'  => 'description',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
