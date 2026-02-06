<?php

namespace Modules\Kandang\Repositories;

use Modules\Kandang\Models\PopulasiAyam;

class PopulasiAyamRepository extends EloquentRepository
{
    public function __construct(PopulasiAyam $model)
    {
        parent::__construct($model);
    }
}
