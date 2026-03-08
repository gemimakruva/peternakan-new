<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanPreMixing extends Model
{
    public $table = 'pakan_pre_mixing';

    protected $fillable = [
        'pic_user_id',
        'formulasi_premix_id',
        'tanggal',
        'jumlah_campuran',
        'harga_total',
    ];

    protected $casts = [
        'jumlah_campuran' => 'float',
        'harga_total' => 'float',
        'created_at' => 'date',
    ];

    public function formulasiPremix()
    {
        return $this->belongsTo(BahanPakanFormulasi::class, 'formulasi_premix_id', 'id');
    }

    public function pakanPreMixingItem()
    {
        return $this->hasMany(PakanPreMixingItem::class, 'pakan_pre_mixing_id', 'id');
    }
}
