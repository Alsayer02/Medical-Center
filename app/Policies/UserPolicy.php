<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Create a new policy instance.
     */
    public function user(User $user)
    {
        return $user->role === 'admin';
    }
}
