<?php

namespace App\Policies;

use App\Models\Institute;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class InstitutePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Institute $institute): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user): bool
    {
        return Gate::denies('isAuthor');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Institute $institute): bool
    {
        return Gate::denies('isAuthor');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Institute  $institute
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Institute $institute): bool
    {
        return Gate::denies('isAuthor');
    }
}
