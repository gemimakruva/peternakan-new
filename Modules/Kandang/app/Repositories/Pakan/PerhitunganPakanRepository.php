<?php

namespace Modules\Kandang\Repositories\Pakan;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\PerhitunganPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class PerhitunganPakanRepository extends EloquentRepository
{
    public function __construct(PerhitunganPakan $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->join('kandang', 'kandang.id', '=', 'perhitungan_pakan.kandang_id')
            ->join('users AS creator', 'creator.id', '=', 'perhitungan_pakan.user_creator_id')
            ->join('jenis_pakan', 'jenis_pakan.id', '=', 'perhitungan_pakan.jenis_pakan_id')
            ->leftJoin('users AS executor', 'executor.id', '=', 'perhitungan_pakan.user_executor_id')
            ->leftJoin('perhitungan_pakan_item', 'perhitungan_pakan_item.perhitungan_pakan_id', '=', 'perhitungan_pakan.id')
            ->selectRaw(<<<SQL
                perhitungan_pakan.*
                , kandang.nama AS nama_kandang
                , creator.name AS nama_pencatat
                , executor.name AS nama_pelaksana
                , jenis_pakan.nama AS nama_jenis_pakan
                , SUM(perhitungan_pakan_item.jumlah_ayam) AS jumlah_ayam
                , SUM(perhitungan_pakan_item.pemberian_pakan_per_ekor * perhitungan_pakan_item.jumlah_ayam) AS berat_pakan_gram
            SQL)
            ->groupBy([
                'perhitungan_pakan.id',
                'kandang.id',
                'creator.id',
                'executor.id',
                'jenis_pakan.id',
            ]);
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where(function($q2) use($search) {
            $q2->where('kandang.nama', 'LIKE', "%$search%")
                ->orWhere('creator.name', 'LIKE', "%$search%")
                ->orWhere('executor.name', 'LIKE', "%$search%");
        });
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id' => function($q, $kandangId) {
                return $q->where('perhitungan_pakan.kandang_id', '=', $kandangId);
            }
        ];
    }
}
