<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanMixingItem extends Model
{
    public $table = 'pakan_mixing_item';

    protected $fillable = [
        'pakan_mixing_id',
        'bahan_pakan_id', // asal bahan raw
        'formulasi_premix_id', // asal bahan premix
        'jumlah',
        'harga_sub_total',
    ];
}
