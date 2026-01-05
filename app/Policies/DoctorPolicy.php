<?php

namespace App\Policies;

use App\Models\User;

class DoctorPolicy
{
    /**
     * Create a new policy instance.
     */
    public function doctor(User $user)
    {
        return  $user->role === 'admin';
    }
}
