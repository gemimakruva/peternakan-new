<?php

namespace Modules\Kandang\Repositories\Pakan;

use Modules\Kandang\Models\JenisPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class JenisPakanRepository extends EloquentRepository
{
    public function __construct(JenisPakan $model)
    {
        parent::__construct($model);
    }
}