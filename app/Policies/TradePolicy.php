<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\Trade;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TradePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Trade $trade)
    {
        return $user->id === $trade->portfolio->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Portfolio $portfolio)
    {
        return $user->id === $portfolio->user_id;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Trade $trade)
    {
        return $user->id === $trade->portfolio->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Trade $trade)
    {
        return $user->id === $trade->portfolio->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Trade $trade)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Trade $trade)
    {
        //
    }

        /**
     * Determine whether the user can favorite the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Trade  $trade
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function favorite(User $user, Trade $trade)
    {
        return $user->id === $trade->portfolio->user_id;
    }
}
