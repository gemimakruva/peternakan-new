<?php

namespace Modules\Kandang\Repositories\Kandang;

use Modules\Kandang\Models\Kandang;
use Modules\Kandang\Repositories\EloquentRepository;

class KandangRepository extends EloquentRepository
{
    public function __construct(Kandang $model)
    {
        parent::__construct($model);
    }
}
