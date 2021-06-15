<?php

namespace App\Observers;

use App\Seat;

class SeatObserver
{
    /**
     * Handle the seat "creating" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function creating(Seat $seat)
    {
        $seat->location = $seat->generateLocationString();
    }

    /**
     * Handle the seat "created" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function created(Seat $seat)
    {
        //

    }

    /**
     * Handle the seat "updating" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function updating(Seat $seat)
    {
        $seat->location = $seat->generateLocationString();
    }

    /**
     * Handle the seat "updated" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function updated(Seat $seat)
    {
        //
    }

    /**
     * Handle the seat "saving" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function saving(Seat $seat)
    {
        $seat->location = $seat->generateLocationString();
    }


    /**
     * Handle the seat "deleted" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function deleted(Seat $seat)
    {
        //
    }

    /**
     * Handle the seat "restored" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function restored(Seat $seat)
    {
        //
    }

    /**
     * Handle the seat "force deleted" event.
     *
     * @param  \App\Seat  $seat
     * @return void
     */
    public function forceDeleted(Seat $seat)
    {
        //
    }
}
