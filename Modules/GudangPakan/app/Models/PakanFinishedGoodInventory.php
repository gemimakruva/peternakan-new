<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanFinishedGoodInventory extends Model
{
    public $table = 'pakan_finished_good_inventory';

    protected $fillable = [
        'tipe',
        'pakan_mixing_id',
        'pakan_finished_good_distribusi_id',
        'formulasi_mix_id',
    ];
}
