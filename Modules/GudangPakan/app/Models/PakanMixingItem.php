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

    protected $casts = [
        'jumlah' => 'float',
        'harga_sub_total' => 'float',
    ];

    public function pakanMixing()
    {
        return $this->belongsTo(PakanMixing::class, 'pakan_mixing_id', 'id');
    }

    public function bahanPakan()
    {
        return $this->belongsTo(BahanPakan::class, 'bahan_pakan_id', 'id');
    }

    public function formulasiPremix()
    {
        return $this->belongsTo(BahanPakanFormulasi::class, 'formulasi_premix_id', 'id');
    }
}
