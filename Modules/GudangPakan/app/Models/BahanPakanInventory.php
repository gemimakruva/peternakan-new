<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class BahanPakanInventory extends Model
{
    public $table = 'bahan_pakan_inventory';

    protected $fillable = [
        'tipe',
        'tanggal',
        'bahan_pakan_pembelian_item_id',
        'pakan_pre_mixing_item_id',
        'bahan_pakan_masuk_id',
        'bahan_pakan_keluar_id',
        'bahan_pakan_opname_id',
        'bahan_pakan_id',
        'jumlah',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
}
