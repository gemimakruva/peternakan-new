<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierKemasan extends Model
{
    public $table = 'supplier_kemasan';

    protected $fillable = [
        'supplier_id',
        'kemasan_id',
        'kode_barang',
        'harga',
        'jenis_pengiriman',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function kemasan()
    {
        return $this->belongsTo(Kemasan::class, 'kemasan_id');
    }
}
