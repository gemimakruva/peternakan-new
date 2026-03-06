<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\BahanPakanFormulasiItemTipe;

class BahanPakanFormulasiItem extends Model
{
    public $table = 'bahan_pakan_formulasi_item';

    protected $fillable = [
        'tipe',
        'bahan_pakan_formulasi_id',
        'formulasi_premix_id',
        'bahan_pakan_id',
        'persentase',
    ];

    protected $casts = [
        'tipe'  => BahanPakanFormulasiItemTipe::class,
    ];

    public function bahanPakanFormulasi()
    {
        return $this->belongsTo(BahanPakanFormulasi::class, 'bahan_pakan_formulasi_id', 'id');
    }

    public function formulasiPremix()
    {
        return $this->belongsTo(BahanPakanFormulasi::class, 'formulasi_premix_id', 'id');
    }

    public function bahanPakan()
    {
        return $this->belongsTo(BahanPakan::class, 'bahan_pakan_id', 'id');
    }
}
