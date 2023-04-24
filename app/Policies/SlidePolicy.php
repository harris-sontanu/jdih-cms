<?php

namespace App\Policies;

use App\Models\Slide;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class SlidePolicy
{
    use HandlesAuthorization;

    /**
     * Perform pre-authorization checks.
     *
     * @param  \App\Models\User  $user
     * @param  string  $ability
     * @return void|bool
     */
    public function before(User $user, $ability): bool
    {
        if (Gate::allows('isAdmin')) return true;
    }

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
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Slide $slide): bool
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
        return true;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Slide $slide): bool
    {
        return Gate::allows('isEditor') OR $user->id === $slide->image->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Slide  $slide
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Slide $slide): bool
    {
        return Gate::allows('isEditor') OR $user->id === $slide->image->user_id;
    }

}
