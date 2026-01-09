<?php

namespace Modules\Kandang\Repositories\Kandang;

use Modules\Kandang\Models\Flock;
use Modules\Kandang\Repositories\EloquentRepository;

class PipeRepository extends EloquentRepository
{
    public function __construct(Flock $model)
    {
        parent::__construct($model);
    }
}
