<?php

namespace Modules\Kandang\Repositories\Treatment;

use Modules\Kandang\Models\MetodeTreatment;
use Modules\Kandang\Repositories\EloquentRepository;

class MetodeTreatmentRepository extends EloquentRepository
{
    public function __construct(MetodeTreatment $model)
    {
        parent::__construct($model);
    }
}
