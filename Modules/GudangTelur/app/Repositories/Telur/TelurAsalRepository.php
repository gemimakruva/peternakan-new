<?php

namespace Modules\GudangTelur\Repositories\Telur;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Models\TelurAsal;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurAsalRepository extends EloquentRepository
{
    public function __construct(TelurAsal $model)
    {
        parent::__construct($model);
    }
}