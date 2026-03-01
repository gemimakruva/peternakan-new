<?php

namespace Modules\GudangTelur\Repositories\Telur;

use Modules\GudangTelur\Models\TelurTujuan;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurTujuanRepository extends EloquentRepository
{
    public function __construct(TelurTujuan $model)
    {
        parent::__construct($model);
    }
}