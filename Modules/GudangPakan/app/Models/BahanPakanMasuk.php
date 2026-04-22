<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\BahanPakanMasukAsal;

class BahanPakanMasuk extends Model
{
    public $table = 'bahan_pakan_masuk';

    protected $fillable = [
        'bahan_pakan_pembelian_id',
        'supplier_id',
        'pic_user_id',
        'asal',
        'tanggal',
    ];

    protected $casts = [
        'tanggal'   => 'date',
        'asal'      => BahanPakanMasukAsal::class,
    ];

    public function bahanPakanInventory()
    {
        return $this->hasMany(BahanPakanInventory::class, 'bahan_pakan_masuk_id', 'id');
    }
}
