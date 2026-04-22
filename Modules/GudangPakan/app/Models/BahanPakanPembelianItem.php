<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class BahanPakanPembelianItem extends Model
{
    public $table = 'bahan_pakan_pembelian_item';
    
    protected $fillable = [
        'bahan_pakan_pembelian_id',
        'bahan_pakan_id',
        'harga_satuan',
        'jumlah',
    ];
}
