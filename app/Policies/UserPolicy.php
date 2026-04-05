<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine if the admin can manage the target user.
     */
    public function manage(User $user, User $target): Response
    {
        if (!$user->hasRole('admin')) {
            return Response::deny('Unauthorized. Admin role required.');
        }

        return $user->id !== $target->id
            ? Response::allow()
            : Response::deny('Senior Rule: You cannot update or delete your own account.');
    }
}
