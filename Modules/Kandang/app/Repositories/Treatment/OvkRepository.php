<?php

namespace Modules\Kandang\Repositories\Treatment;

use Modules\Kandang\Models\Ovk;
use Modules\Kandang\Repositories\EloquentRepository;

class OvkRepository extends EloquentRepository
{
    public function __construct(Ovk $model)
    {
        parent::__construct($model);
    }
}
