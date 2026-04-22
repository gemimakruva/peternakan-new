<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanMixing extends Model
{
    public $table = 'pakan_mixing';
    
    protected $fillable = [
        'pic_user_id',
        'formulasi_mix_id',
        'tanggal',
        'jumlah_campuran',
        'harga_total',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
        'jumlah_campuran' => 'float',
        'harga_total' => 'float',
    ];

    public function formulasiMix()
    {
        return $this->belongsTo(BahanPakanFormulasi::class, 'formulasi_mix_id', 'id');
    }

    public function pakanMixingItem()
    {
        return $this->hasMany(PakanMixingItem::class, 'pakan_mixing_id', 'id');
    }
}
