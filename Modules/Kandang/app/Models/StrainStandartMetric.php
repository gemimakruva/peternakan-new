<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class StrainStandartMetric extends Model
{
    protected $table = 'strain_standart_metric';

    protected $fillable = [
        'strain_id',
        'umur',
        'berat_badan_min',
        'berat_badan_max',
        'berat_badan',
        'persentase_kematian',
        'feed_intake',
        'fcr',
        'hdp',
        'hhp',
        'egg_weight',
        'egg_mass',
    ];


    public function strain()
    {
        return $this->belongsTo(Strain::class, 'strain_id');
    }
}
