<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\PakanFinishedGoodInventoryTipe;

class PakanFinishedGoodInventory extends Model
{
    public $table = 'pakan_finished_good_inventory';

    protected $fillable = [
        'pakan_mixing_id', // masuk
        'pakan_finished_good_distribusi_id', // keluar
        'formulasi_mix_id', // jenis
        'tipe',
        'tanggal',
        'jumlah',
    ];

    protected $casts = [
        'tipe' => PakanFinishedGoodInventoryTipe::class,
        'tanggal' => 'datetime',
        'jumlah' => 'float',
    ];
}
