<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class Ovk extends Model
{
    public $table = 'ovk';

    protected $fillable = [
        'jenis_ovk_id',
        'nama',
        'dosis_pembilang',
        'dosis_pembilang_satuan_id',
        'dosis_penyebut',
        'dosis_penyebut_satuan_id',
        'penggunaan_per_hari',
        'penggunaan_per_hari_satuan_id',
        'harga',
        'harga_per_satuan',
        'harga_per_satuan_id',
    ];

    // dosis
    // tota penggunaan per bulan
}
