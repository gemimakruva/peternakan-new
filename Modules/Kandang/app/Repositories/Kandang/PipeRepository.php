<?php

namespace Modules\Kandang\Repositories\Kandang;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\Pipe;
use Modules\Kandang\Repositories\EloquentRepository;

class PipeRepository extends EloquentRepository
{
    public function __construct(Pipe $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->join('flock', 'flock.id', '=', 'pipe.flock_id')
            ->join('kandang', 'kandang.id', '=', 'flock.kandang_id')
            ->join('peternakan', 'peternakan.id', '=', 'kandang.peternakan_id')
            ->selectRaw(<<<SQL
                pipe.*
                , pipe.nama AS nama_pipe
                , flock.nama AS nama_flock
                , kandang.nama AS nama_kandang
                , peternakan.nama AS nama_peternakan
            SQL);
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where(function($q2) use($search) {
            $q2->where('pipe.nama', 'LIKE', "%$search%")
                ->orWhere('flock.nama', 'LIKE', "%$search%")
                ->orWhere('kandang.nama', 'LIKE', "%$search%");
        });
    }
}
