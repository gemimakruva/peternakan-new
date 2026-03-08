<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\PakanPreMixingInventoryTipe;

class PakanPreMixingInventory extends Model
{
    public $table = 'pakan_pre_mixing_inventory';

    protected $fillable = [
        'tipe',
        'pakan_pre_mixing_id',
        'pakan_mixing_id',
        'formulasi_premix_id',
        'jumlah',
    ];

    protected $casts = [
        'tipe' => PakanPreMixingInventoryTipe::class,
    ];
}
