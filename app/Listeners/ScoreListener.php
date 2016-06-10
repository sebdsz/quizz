<?php

namespace App\Listeners;

use App\Events\ScoreEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ScoreListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ScoreEvent  $event
     * @return void
     */
    public function handle(ScoreEvent $event)
    {
        //
    }
}
