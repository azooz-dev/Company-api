<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier'     => (int) $this->id,
            'name'           => (string) $this->name,
            'email'          => (string) $this->email,
            'isVerified'     => (boolean) $this->isVerified() == 'true',
            'isAdmin'        => (boolean) $this->isAdmin() == 'true',
            'createdDate'    => (string) $this->created_at,
            'lastChange'     => (string) $this->updated_at,
            'deletedDate'    => (string) $this->deleted_at ? $this->deleted_at : null,
        ];
    }

    public static function transformAttribute($index) {
        $attributes = [
            'identifier'     => 'id',
            'name'           => 'name',
            'email'          => 'email',
            'isVerified'     => 'verified',
            'isAdmin'        => 'admin',
            'createdDate'    => 'created_at',
            'lastChange'     => 'updated_at',
            'deletedDate'    => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
