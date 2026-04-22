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
        'persentase' => 'float'
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

    public function getKebutuhanPerKgAttribute()
    {
        if ($this->attributes['formulasi_premix_id']) {
            return (object) [
                'persentase' => $this->attributes['persentase']/100,
                'bahan' => $this->formulasiPremix->nama,
                'satuan' => 'Kg',
                'konversi' => 1, // basis konversi kg
                'kebutuhan' => $this->attributes['persentase']/100, // konversi sesuai satuan
            ];
        } else {
            return (object) [
                'persentase' => $this->attributes['persentase']/100,
                'bahan' => $this->bahanPakan->nama,
                'satuan' => $this->bahanPakan->satuan->nama,
                'konversi' => $this->bahanPakan->satuan->konversi_satuan/1000, // basis konversi kg
                'kebutuhan' => ($this->attributes['persentase']/100)/($this->bahanPakan->satuan->konversi_satuan/1000), // konversi sesuai satuan
            ];
        }
    }
}
