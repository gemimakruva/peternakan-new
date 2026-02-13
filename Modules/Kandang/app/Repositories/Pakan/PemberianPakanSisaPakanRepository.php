<?php

namespace Modules\Kandang\Repositories\Pakan;

use Illuminate\Database\Eloquent\Builder;
use Modules\Kandang\Models\PemberianPakanSisaPakan;
use Modules\Kandang\Repositories\EloquentRepository;

class PemberianPakanSisaPakanRepository extends EloquentRepository
{
    public function __construct(PemberianPakanSisaPakan $model)
    {
        parent::__construct($model);
    }

    public function getQuery(): Builder
    {
        return $this->model
            ->query()
            ->rightJoin('perhitungan_pakan', 'perhitungan_pakan.id', '=', 'pemberian_pakan_sisa_pakan.perhitungan_pakan_id')
            ->join('users AS executor', 'executor.id', '=', 'perhitungan_pakan.user_executor_id')
            ->join('kandang', 'kandang.id', '=', 'perhitungan_pakan.kandang_id')
            ->join('jenis_pakan', 'jenis_pakan.id', '=', 'perhitungan_pakan.jenis_pakan_id')
            ->leftJoinSub(
                function($q) {
                    $q
                        ->selectRaw(<<<SQL
                            ppi.perhitungan_pakan_id
                            , SUM(ppi.pemberian_pakan_per_ekor * ppi.jumlah_ayam) AS total_pakan
                        SQL)
                        ->from('perhitungan_pakan_item as ppi')
                        ->groupBy('ppi.perhitungan_pakan_id');
                }, 
                'xppi', 
                'xppi.perhitungan_pakan_id', 
                '=', 
                'perhitungan_pakan.id')
            ->selectRaw(<<<SQL
                perhitungan_pakan.id
                , perhitungan_pakan.tanggal_pemberian_pakan
                , kandang.nama AS nama_kandang
                , jenis_pakan.nama AS nama_jenis_pakan
                , executor.name AS nama_pelaksana
                , xppi.total_pakan/1000 AS pemberian_pakan_kg
                , SUM(pemberian_pakan_sisa_pakan.sisa_pakan_per_flock_kg) AS sisa_pakan_kg
            SQL)
            ->groupBy('perhitungan_pakan.id');
    }

    public function searchQuery(Builder $q, string $search): void
    {
        $q->where(function($q2) use($search) {
            $q2->where('kandang.nama', 'LIKE', "%$search%")
                ->orWhere('executor.name', 'LIKE', "%$search%");
        });
    }

    public function customWhereQuery(): array
    {
        return [
            'kandang_id' => function($q, $kandangId) {
                return $q->where('perhitungan_pakan.kandang_id', '=', $kandangId);
            },
            'jenis_pakan_id' => function($q, $jenisPakanId) {
                return $q->where('jenis_pakan.id', '=', $jenisPakanId);
            },
        ];
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderBy("perhitungan_pakan.updated_at", 'desc');
        $q->orderBy("perhitungan_pakan.id", 'desc');
    }
}
