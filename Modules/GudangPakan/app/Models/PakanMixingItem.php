<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanMixingItem extends Model
{
    public $table = 'pakan_mixing_item';

    protected $fillable = [
        'pakan_mixing_id',
        'bahan_pakan_id',
        'pakan_pre_mixing_id',
        'jumlah',
        'harga_sub_total',
    ];
}
