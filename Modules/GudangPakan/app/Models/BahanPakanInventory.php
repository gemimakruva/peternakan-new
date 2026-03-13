<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\BahanPakanInventoryTipe;

class BahanPakanInventory extends Model
{
    public $table = 'bahan_pakan_inventory';

    protected $fillable = [
        'tipe',
        'tanggal',
        'bahan_pakan_pembelian_item_id', // masuk
        'pakan_pre_mixing_item_id', // keluar untuk pre-mixing
        'pakan_mixing_item_id', // keluar untuk mixing
        'bahan_pakan_masuk_id',
        'bahan_pakan_keluar_id',
        'bahan_pakan_opname_id',
        'bahan_pakan_id',
        'jumlah',
        'harga_satuan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'float',
        'harga_satuan' => 'float',
    ];
}
