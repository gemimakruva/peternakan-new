<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisDisinfektan extends Model
{

    use HasFactory;

    protected $table = 'jenis_disinfektan';

    protected $fillable = [
        'nama'
    ];
}
