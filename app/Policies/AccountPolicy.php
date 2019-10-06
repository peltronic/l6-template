<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Account;

class AccountPolicy extends Policy
{
    public function update(User $user, Account $account)
    {
        // return $account->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Account $account)
    {
        return true;
    }
}
