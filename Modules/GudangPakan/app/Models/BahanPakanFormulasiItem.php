<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class BahanPakanFormulasiItem extends Model
{
    public $table = 'bahan_pakan_formulasi_item';

    protected $fillable = [
        'bahan_pakan_formulasi_id',
        'bahan_pakan_id',
        'persentase',
    ];
}
