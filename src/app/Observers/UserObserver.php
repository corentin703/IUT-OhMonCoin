<?php

namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    public function deleting(User $user)
    {
        if ($user->isForceDeleting())
        {
            if ($user->id === Auth::id())
                Auth::logout();

            foreach ($user->adverts()->withTrashed()->get() as $advert)
                $advert->forceDelete();

            foreach ($user->followPivot as $followPivot)
                $followPivot->forceDelete();
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        foreach ($user->adverts as $advert)
            $advert->delete();
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        foreach ($user->adverts()->withTrashed()->get() as $advert)
            $advert->restore();
    }

    /**
     * Handle the advert "force deleted" event.
     *
     * @param  \App\User  $advert
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

}
