<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Models\SupplierBahanPakan;
use Modules\GudangTelur\Enums\SupplierTipe;

class Supplier extends Model
{
    public $table = 'supplier';

    protected $fillable = [
        'tipe',
        'nama',
        'badan_usaha',
        'kontak',
        'alamat',
        'lokasi',
    ];

    public function getTipeEnumAttribute()
    {
        if (!$this->attributes['tipe']) {
            return null;
        }
        return SupplierTipe::tryFrom($this->attributes['tipe']);
    }

    public function supplierKemasan()
    {
        return $this->hasMany(SupplierKemasan::class, 'supplier_id', 'id');
    }

    public function supplierBahanPakan()
    {
        return $this->hasMany(SupplierBahanPakan::class, 'supplier_id', 'id');
    }
}
