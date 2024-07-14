<?php

namespace App\Policies;

use App\Models\User;
use App\Traits\AdminActions;

class UserPolicy
{
    use AdminActions;
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $authenticatedUser, User $user): bool
    {
        return $authenticatedUser->id === $user->id;
    }

}
