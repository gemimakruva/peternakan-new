<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class JenisPakan extends Model
{
    protected $table = 'jenis_pakan';

    protected $fillable = [
        'nama',
    ];
}
