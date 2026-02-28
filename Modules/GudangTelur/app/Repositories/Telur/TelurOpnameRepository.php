<?php

namespace Modules\GudangTelur\Repositories\Telur;

use Modules\GudangTelur\Models\TelurOpname;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurOpnameRepository extends EloquentRepository
{
    public function __construct(TelurOpname $model)
    {
        parent::__construct($model);
    }
}