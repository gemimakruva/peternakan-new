<?php

namespace Modules\Kandang\Repositories\Treatment;

use Modules\Kandang\Models\JenisTreatment;
use Modules\Kandang\Repositories\EloquentRepository;

class JenisTreatmentRepository extends EloquentRepository
{
    public function __construct(JenisTreatment $model)
    {
        parent::__construct($model);
    }
}
