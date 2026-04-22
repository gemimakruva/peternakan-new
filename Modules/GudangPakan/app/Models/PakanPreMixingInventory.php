<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;

class PakanPreMixingInventory extends Model
{
    public $table = 'pakan_pre_mixing_inventory';

    protected $fillable = [
        'pakan_pre_mixing_id', // masuk
        'pakan_mixing_item_id', // keluar
        'pakan_pre_mixing_opname_id', // opname
        'formulasi_premix_id', // jenis
        'tipe',
        'tanggal',
        'jumlah',
    ];

    protected $casts = [
        'tipe' => PakanPreMixingInventoryTipe::class,
        'tanggal' => 'datetime',
        'jumlah' => 'float',
    ];

    public function bahanPakanFormulasi()
    {
        $this->belongsTo(BahanPakanFormulasi::class, 'formulasi_premix_id');
    }
}
