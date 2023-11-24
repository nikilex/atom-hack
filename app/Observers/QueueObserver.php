<?php

namespace App\Observers;

use App\Models\Equipment;
use App\Models\Queue;

class QueueObserver
{

    public function saving(Queue $queue): void
    {
        $equipment = Equipment::inRandomOrder()->first();

        if ($equipment) {
            $queue->equipment_id = $equipment->id;
        }
    }

    /**
     * Handle the Queue "created" event.
     */
    public function created(Queue $queue): void
    {
        //
    }

    /**
     * Handle the Queue "updated" event.
     */
    public function updated(Queue $queue): void
    {
        //
    }

    /**
     * Handle the Queue "deleted" event.
     */
    public function deleted(Queue $queue): void
    {
        //
    }

    /**
     * Handle the Queue "restored" event.
     */
    public function restored(Queue $queue): void
    {
        //
    }

    /**
     * Handle the Queue "force deleted" event.
     */
    public function forceDeleted(Queue $queue): void
    {
        //
    }
}
