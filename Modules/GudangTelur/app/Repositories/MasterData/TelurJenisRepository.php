<?php

namespace Modules\GudangTelur\Repositories\MasterData;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangTelur\Models\TelurJenis;
use Modules\Kandang\Repositories\EloquentRepository;

class TelurJenisRepository extends EloquentRepository
{
    private $tipe;

    public function __construct(TelurJenis $model)
    {
        parent::__construct($model);
    }

    public function setContext($tipe)
    {
        $this->tipe = $tipe;

        return $this;
    }

    public function getQuery(): Builder
    {
        $query = $this->model
            ->query()
            ->when($this->tipe, function($query, $tipe) {
                $query->where('tipe', '=', $tipe);
            });

        return $query;
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where('nama', 'LIKE', "%$search%");
    }
}