<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class JenisTreatment extends Model
{
    protected $table = 'jenis_treatment';

    protected $fillable = [
        'nama',
    ];
}
