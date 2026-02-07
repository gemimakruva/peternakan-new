<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class Satuan extends Model
{
    public $table = 'satuan';

    protected $fillable = [
        'nama',
        'standar_terkecil_satuan',
    ];
}
