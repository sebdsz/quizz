<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ScoreEvent extends Event
{
    use SerializesModels;

    public $postId;
    public $score;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($postId, $score)
    {
        $this->postId = $postId;
        $this->score = $score;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
