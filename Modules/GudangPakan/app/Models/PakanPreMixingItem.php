<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanPreMixingItem extends Model
{
    public $table = 'pakan_pre_mixing_item';

    protected $fillable = [
        'pakan_pre_mixing_id',
        'bahan_pakan_id',
        'jumlah',
        'harga_sub_total',
    ];

    protected $casts = [
        'jumlah' => 'integer',
        'harga_sub_total' => 'float',
    ];

    public function bahanPakan()
    {
        return $this->belongsTo(BahanPakan::class, 'bahan_pakan_id', 'id');
    }

    public function bahanPakanInventory()
    {
        return $this->hasOne(BahanPakanInventory::class, 'pakan_pre_mixing_item_id', 'id');
    }
}
