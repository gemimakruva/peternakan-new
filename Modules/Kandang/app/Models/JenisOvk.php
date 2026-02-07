<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class JenisOvk extends Model
{
    public $table = 'jenis_ovk';

    protected $fillable = [
        'nama',
    ];
}
