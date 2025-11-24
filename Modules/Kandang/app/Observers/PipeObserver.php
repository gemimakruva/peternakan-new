<?php

namespace Modules\Kandang\Observers;

use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Helper\FlockHelper;

class PipeObserver
{
    public function created(Pipe $pipe)
    {
        FlockHelper::updateFlockCapacity($pipe->flock_id);
    }

    public function updated(Pipe $pipe)
    {
        FlockHelper::updateFlockCapacity($pipe->flock_id);
    }

    public function deleted(Pipe $pipe)
    {
        FlockHelper::updateFlockCapacity($pipe->flock_id);
    }
}
