<?php

namespace App\Transformers\User;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
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
    public function transform(User $user)
    {
        return [
            'identifier'   => (int) $user->id,
            'name'         => (string) $user->name,
            'email'        => (string) $user->email,
            'isVerified'   => (int) $user->verified,
            'isAdmin'      => (boolean) ($user->admin === 'true'),
            'creationDate' => (string) $user->created_at,
            'lastChange'   => (string) $user->updated_at,
            'deletedDate'  => (string) $user->deleted_at ? $user->deleted_at : null
        ];
    }

    public static function originalAttribute($index) {
        $attributes = [
            'identifier'  => 'id',
            'name'        => 'name',
            'email'       => 'email',
            'isVerified'  => 'verified',
            'isAdmin'     => 'admin',
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
            'admin'      => 'isAdmin',
            'created_at' => 'createDate',
            'updated_at' => 'lastChange',
            'deleted_at' => 'deletedDate',
        ];

        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
