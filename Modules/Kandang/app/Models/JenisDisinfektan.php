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

    protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\JenisDisinfektanFactory::new();
    }
     

}
