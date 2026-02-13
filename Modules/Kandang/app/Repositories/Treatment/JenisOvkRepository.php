<?php

namespace Modules\Kandang\Repositories\Treatment;

use Modules\Kandang\Models\JenisOvk;
use Modules\Kandang\Repositories\EloquentRepository;

class JenisOvkRepository extends EloquentRepository
{
    public function __construct(JenisOvk $model)
    {
        parent::__construct($model);
    }
}
