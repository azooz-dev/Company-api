<?php

namespace App\Http\Resources\Seller;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SellerResource extends JsonResource
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
            'links'          => [
                [
                    'rel'  => 'self',
                    'href' => route('sellers.show', $this->id)
                ],
                [
                    'rel'  => 'seller.buyers',
                    'href' => route('sellers.buyers.index', $this->id)
                ],
                [
                    'rel'  => 'seller.categories',
                    'href' => route('sellers.categories.index', $this->id)
                ],
                [
                    'rel'  => 'seller.products',
                    'href' => route('sellers.products.index', $this->id)
                ],
                [
                    'rel'  => 'seller.transactions',
                    'href' => route('sellers.transactions.index', $this->id)
                ],
                [
                    'rel'  => 'seller.profile',
                    'href' => route('users.show', $this->id)
                ],
            ]
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
