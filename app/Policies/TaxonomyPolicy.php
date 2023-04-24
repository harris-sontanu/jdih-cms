<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Taxonomy;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class TaxonomyPolicy
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
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Taxonomy $taxonomy): bool
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
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Taxonomy $taxonomy): bool
    {
        return Gate::denies('isAuthor');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Taxonomy  $taxonomy
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Taxonomy $taxonomy): bool
    {
        return Gate::denies('isAuthor');
    }
}
