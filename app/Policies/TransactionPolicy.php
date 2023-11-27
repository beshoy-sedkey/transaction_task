<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function view(User $user)
    {
       return $user->is_admin == true;
    }

    public function create(User $user)
    {
        return $user->is_admin == true;
        // Add your logic to determine if the user can create transactions
    }

    public function update(User $user)
    {
        return $user->is_admin == true;
    }

    public function delete(User $user)
    {
        return $user->is_admin == true;
    }
}
