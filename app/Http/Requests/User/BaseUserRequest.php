<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

abstract class BaseUserRequest extends BaseRequest
{

    // Define the common validation rules to be implemented by UserStoreRequest & UserUpdateRequest classes
    public abstract function rules(): array;

    // Common attribute names for users
    public function attributes(): array {
        return [
            'id'         => 'identifier',
            'name'       => 'name',
            'email'      => 'email',
            'password'   => 'password',
            'admin'      => 'admin',
            'created_at' => 'createdDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];
    }

    // Common transformation of attributes for users
    public static function transformAttributes($index) {
        $attribute = [
            'identifier'  => 'id',
            'name'        => 'name',
            'email'       => 'email',
            'password'    => 'password',
            'isAdmin'     => 'admin',
        ];

        return isset($attribute[$index]) ? $attribute[$index] : null;
    }
}
