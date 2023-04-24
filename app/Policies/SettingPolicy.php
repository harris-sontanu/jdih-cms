<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class SettingPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return Gate::denies('isAuthor');
    }

    public function update(User $user): bool
    {
        return Gate::denies('isAuthor');
    }
}
