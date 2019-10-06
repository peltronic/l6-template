<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Listing;

class ListingPolicy extends Policy
{
    public function update(User $user, Listing $listing)
    {
        // return $listing->user_id == $user->id;
        return true;
    }

    public function destroy(User $user, Listing $listing)
    {
        return true;
    }
}
