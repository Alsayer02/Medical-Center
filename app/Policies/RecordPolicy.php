<?php

namespace App\Policies;

use App\Models\User;

class RecordPolicy
{
    /**
     * Create a new policy instance.
     */
    public function create(User $user)
    {
        return $user->role === 'doctor';
    }
    public function update(User $user,$record)
    {
        return $user->role === 'admin' || ($user->role === 'doctor' && $user->id === $record->doctor_id);
    }
    public function delete(User $user)
    {
        return  $user->role === 'doctor' || $user->role === 'admin';
    }
    public function view(User $user)
    {
        return $user->role === 'user' || $user->role === 'admin' || $user->role === 'doctor';
    }
}
