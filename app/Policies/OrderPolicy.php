<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function update(User $user, Order $order)
    {
        return $user->isAdmin() || $user->isKasir();
    }

    public function delete(User $user, Order $order)
    {
        return $user->isAdmin();
    }
}
