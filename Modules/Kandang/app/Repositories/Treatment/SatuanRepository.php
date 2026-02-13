<?php

namespace Modules\Kandang\Repositories\Treatment;

use Modules\Kandang\Models\Satuan;
use Modules\Kandang\Repositories\EloquentRepository;

class SatuanRepository extends EloquentRepository
{
    public function __construct(Satuan $model)
    {
        parent::__construct($model);
    }
}
