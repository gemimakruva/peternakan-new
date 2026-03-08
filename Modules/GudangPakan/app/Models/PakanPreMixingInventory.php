<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;

class PakanPreMixingInventory extends Model
{
    public $table = 'pakan_pre_mixing_inventory';

    protected $fillable = [
        'pakan_pre_mixing_id',
        'pakan_mixing_id',
        'formulasi_premix_id',
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
