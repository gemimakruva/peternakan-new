<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    public $table = 'satuan';

    protected $fillable = [
        'nama',
        'konversi_satuan',
    ];

    protected $casts = [
        'konversi_satuan' => 'float',
    ];
}
