<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class BahanPakanFormulasiBerat extends Model
{
    public $table = 'bahan_pakan_formulasi_berat';

    protected $fillable = [
        'bahan_pakan_formulasi_id',
        'berat',
    ];
}
