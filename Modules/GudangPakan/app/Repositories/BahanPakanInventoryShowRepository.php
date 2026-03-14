<?php

namespace Modules\GudangPakan\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;
use Modules\GudangPakan\Models\BahanPakan;
use Modules\GudangPakan\Models\BahanPakanInventory;
use Modules\Kandang\Repositories\EloquentRepository;

class BahanPakanInventoryShowRepository extends EloquentRepository
{
    private $bahanPakanId;

    public function __construct(BahanPakanInventory $model)
    {
        parent::__construct($model);
    }

    public function setContext($bahanPakanId)
    {
        $this->bahanPakanId = $bahanPakanId;
        return $this;
    }

    public function getQuery(): Builder
    {
        $query = $this->model->query()
            ->leftJoin('bahan_pakan', 'bahan_pakan.id', '=', 'bahan_pakan_inventory.bahan_pakan_id')
            ->leftJoin('satuan', 'satuan.id', '=', 'bahan_pakan.satuan_id')
            ->where('bahan_pakan_inventory.bahan_pakan_id', '=', $this->bahanPakanId)
            ->selectRaw(<<<SQL
                bahan_pakan.id
                , bahan_pakan_inventory.id as id2
                , bahan_pakan.nama as nama_bahan_pakan
                , satuan.nama as nama_satuan
                , bahan_pakan_inventory.jumlah
                , bahan_pakan_inventory.tipe
                , bahan_pakan_inventory.tanggal
                , bahan_pakan_inventory.created_at
                , SUM(
                    CASE
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah
                        WHEN bahan_pakan_inventory.tipe = ? THEN -bahan_pakan_inventory.jumlah
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah
                        ELSE 0
                    END
                ) OVER (
                    ORDER BY 
                        bahan_pakan_inventory.tanggal ASC
                        , bahan_pakan_inventory.created_at ASC
                    ROWS BETWEEN UNBOUNDED PRECEDING AND CURRENT ROW
                ) as saldo
                , bahan_pakan_inventory.harga_satuan
                , SUM(
                    CASE
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah*bahan_pakan_inventory.harga_satuan
                        WHEN bahan_pakan_inventory.tipe = ? THEN -(bahan_pakan_inventory.jumlah*bahan_pakan_inventory.harga_satuan)
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah*bahan_pakan_inventory.harga_satuan
                        ELSE 0
                    END
                ) OVER (
                    ORDER BY bahan_pakan_inventory.tanggal, bahan_pakan_inventory.created_at
                )/
                SUM(
                    CASE
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah
                        WHEN bahan_pakan_inventory.tipe = ? THEN -(bahan_pakan_inventory.jumlah)
                        WHEN bahan_pakan_inventory.tipe = ? THEN bahan_pakan_inventory.jumlah
                        ELSE 1
                    END
                ) OVER (
                    ORDER BY bahan_pakan_inventory.tanggal, bahan_pakan_inventory.created_at
                ) AS mwa
            SQL, [
                BahanPakanInventoryTipe::MASUK->value,
                BahanPakanInventoryTipe::KELUAR->value,
                BahanPakanInventoryTipe::OPNAME->value,

                BahanPakanInventoryTipe::MASUK->value,
                BahanPakanInventoryTipe::KELUAR->value,
                BahanPakanInventoryTipe::OPNAME->value,

                BahanPakanInventoryTipe::MASUK->value,
                BahanPakanInventoryTipe::KELUAR->value,
                BahanPakanInventoryTipe::OPNAME->value,
            ])
            ->groupBy('bahan_pakan_inventory.id');

        return $query;
    }

    public function defaultOrder(Builder $q): void
    {
        $q->orderByDesc('bahan_pakan_inventory.tanggal');
        $q->orderByDesc('bahan_pakan_inventory.created_at');
        $q->orderByDesc('bahan_pakan_inventory.id');
    }

    /**
     * ambil mwa terakhir untuk validate isi transaksi selain barang masuk, dengan asumsi transaksi selain barang masuk tidak mempengaruhi mwa
     * @param mixed $bahanPakanId
     * @param mixed $bahanPakanInventory
     * @return float
     */
    public function getLatestMwa($bahanPakanId, ?BahanPakanInventory $bahanPakanInventory = null)
    {
        $hargaBahanPakan = (float) app(BahanPakan::class)->where('id', '=', $bahanPakanId)->value('harga_satuan');

        $mwa = (float) $this->setContext($bahanPakanId)->getQuery()
            ->when($bahanPakanInventory, function ($query, $bahanPakanInventory) {
                // untuk case add inventory tidak di tanggal terbaru
                $query->where('bahan_pakan_inventory.tanggal', '<=', $bahanPakanInventory->tanggal);
                $query->where('bahan_pakan_inventory.created_at', '<', $bahanPakanInventory->created_at);
            })
            ->orderByDesc('bahan_pakan_inventory.tanggal')
            ->orderByDesc('bahan_pakan_inventory.created_at')
            ->orderByDesc('bahan_pakan_inventory.id')
            ->limit(1)->value('mwa');

        return ($mwa == 0) ? $hargaBahanPakan : $mwa;
    }
}