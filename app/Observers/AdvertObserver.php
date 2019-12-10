<?php

namespace App\Observers;

use App\Advert;

class AdvertObserver
{
    /**
     * Handle the advert "created" event.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function created(Advert $advert)
    {
        //
    }

    /**
     * Handle the advert "updated" event.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function updated(Advert $advert)
    {
        //
    }

    public function deleting(Advert $advert)
    {
        if ($advert->isForceDeleting())
        {
            foreach ($advert->followPivot as $followPivot)
                $followPivot->forceDelete();
				
            foreach ($advert->messages()->get() as $message)
                $message->forceDelete();
				
            foreach ($advert->pictures()->withTrashed()->get() as $picture)
                $picture->forceDelete();
        }
    }

    /**
     * Handle the advert "deleted" event.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function deleted(Advert $advert)
    {
        foreach ($advert->pictures as $picture)
        {
            $picture->delete();
        }
    }

    /**
     * Handle the advert "restored" event.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function restored(Advert $advert)
    {
        foreach ($advert->pictures()->withTrashed()->get() as $picture)
            $picture->restore();
    }

    /**
     * Handle the advert "force deleted" event.
     *
     * @param  \App\Advert  $advert
     * @return void
     */
    public function forceDeleted(Advert $advert)
    {
        //
    }
}
