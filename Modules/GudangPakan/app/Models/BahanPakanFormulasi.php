<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\BahanPakanFormulasiTipe;

class BahanPakanFormulasi extends Model
{
    public $table = 'bahan_pakan_formulasi';

    protected $fillable = [
        'pic_user_id',
        'jenis_pakan_id',
        'tipe',
        'nama',
        'harga_per_kg',
    ];

    protected $casts = [
        'tipe'  => BahanPakanFormulasiTipe::class,
        'harga_per_kg' => 'float',
    ];

    public function bahanPakanFormulasiItem()
    {
        return $this->hasMany(BahanPakanFormulasiItem::class, 'bahan_pakan_formulasi_id', 'id');
    }

    public function bahanPakanFormulasiBerat()
    {
        return $this->hasMany(BahanPakanFormulasiBerat::class, 'bahan_pakan_formulasi_id', 'id');
    }
}
