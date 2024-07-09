<?php

namespace App\Transformers\Seller;

use App\Models\Seller;
use League\Fractal\TransformerAbstract;

class SellerTransformer extends TransformerAbstract
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
    public function transform(Seller $seller)
    {
        return [
            'identifier'   => (int) $seller->id,
            'name'         => (string) $seller->name,
            'email'        => (string) $seller->email,
            'isVerified'   => (int) $seller->verified,
            'isAdmin'      => (string) ($seller->admin === 'true'),
            'creationDate' => (string) $seller->created_at,
            'lastChange'   => (string) $seller->updated_at,
            'deletedDate'  => (string) ($seller->deleted_at ? $seller->deleted_at : null)
        ];
    }
}
