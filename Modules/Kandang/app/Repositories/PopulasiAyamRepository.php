<?php

namespace Modules\Kandang\Repositories;

use Illuminate\Support\Facades\DB;
use Modules\Kandang\Models\PopulasiAyam;

class PopulasiAyamRepository extends EloquentRepository
{
    public function __construct(PopulasiAyam $model)
    {
        parent::__construct($model);
    }

    public function getChickensPerRow(int $flockId, ?string $date = null): int
    {
        return DB::table('populasi_ayam')
            ->join('pipe', 'populasi_ayam.pipe_id', '=', 'pipe.id')
            ->when(isset($date), function ($query) use ($date) {
                $query->whereDate('populasi_ayam.tanggal', $date);
            })
            ->where('pipe.flock_id', $flockId)
            ->sum('populasi_ayam.ayam_sehat');
    }
}
