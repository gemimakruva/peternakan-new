<?php

namespace Modules\Kandang\Repositories\Disinfektan;

use Modules\Kandang\Models\JenisDisinfektan;
use Modules\Kandang\Repositories\EloquentRepository;

class JenisDisinfektanRepository extends EloquentRepository
{
    public function __construct(JenisDisinfektan $model)
    {
        parent::__construct($model);
    }
}
