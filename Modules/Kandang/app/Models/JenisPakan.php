<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Database\Factories\JenisPakanFactory;


class JenisPakan extends Model
{
    use HasFactory;

    protected $table = 'jenis_pakan';

    protected $fillable = [
        'nama',
    ];

    /**
     * Hubungkan model dengan Factory yang ada di Modules
     */
    protected static function newFactory()
    {
        return JenisPakanFactory::new();
    }
}
