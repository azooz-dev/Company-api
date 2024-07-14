<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use App\Traits\AdminActions;

class TransactionPolicy
{
    use AdminActions;
    /**
     * Determine whether the user can view the model.
     */
    public function see(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->buyer_id || $user->id === $transaction->product->seller_id;
    }

}
