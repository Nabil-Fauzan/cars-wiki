<?php

namespace App\Policies;

use App\Models\Car;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CarPolicy
{
    public function viewAny(User $user): bool
    {
        return true; // Everyone can see list
    }

    public function view(User $user, Car $car): bool
    {
        return true; // Everyone can see detail
    }

    public function create(User $user): bool
    {
        return $user->hasPermissionTo('manage cars');
    }

    public function update(User $user, Car $car): bool
    {
        return $user->hasPermissionTo('manage cars');
    }

    public function delete(User $user, Car $car): bool
    {
        return $user->hasPermissionTo('manage cars');
    }

    public function duplicate(User $user): bool
    {
        return $user->hasPermissionTo('manage cars');
    }
}
