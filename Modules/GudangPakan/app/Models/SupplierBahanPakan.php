<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierBahanPakan extends Model
{
    public $table = 'supplier_bahan_pakan';

    protected $fillable = [
        'supplier_id',
        'bahan_pakan_id',
    ];
}
