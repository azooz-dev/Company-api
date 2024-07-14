<?php

namespace App\Policies;

use App\Models\Seller;
use App\Models\User;
use App\Traits\AdminActions;

class SellerPolicy
{
    use AdminActions;
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Seller $seller): bool
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the seller can update the product.
     */
    public function editProduct(User $user, Seller $seller): bool
    {
        return $user->id === $seller->id;
    }

    /**
     * Determine whether the seller can delete the product.
     */
    public function deleteProduct(User $user, Seller $seller): bool
    {
        return $user->id === $seller->id;
    }

}
