<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    public $table = 'supplier';

    protected $fillable = [
        'nama',
        'badan_usaha',
        'kontak',
        'alamat',
        'lokasi',
    ];

    public function supplierKemasan()
    {
        return $this->hasMany(SupplierKemasan::class, 'supplier_id', 'id');
    }
}
