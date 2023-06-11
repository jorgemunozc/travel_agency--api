<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Travel;
use App\Models\User;

class TravelPolicy
{
    public function before(?User $user, string $ability): ?bool
    {
        if (! is_null($user) && $user->isAdmin()) {
            return true;
        }

        return null;
    }

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Travel $travel): bool
    {
        return $travel->isPublic();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(?User $user): bool
    {
        return ! is_null($user) && $user->isAdmin();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->isAdmin() || $user->isEditor();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Travel $travel): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Travel $travel): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Travel $travel): bool
    {
        return true;
    }
}
