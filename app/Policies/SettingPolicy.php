<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class SettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return Gate::denies('isAuthor');
    }

    public function update(User $user)
    {
        return Gate::denies('isAuthor');
    }
}
