<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class JenisPakan extends Model
{
     use HasFactory;

    public $table = 'jenis_pakan'; 

    protected $fillable = [
        'nama',
    ];

}
