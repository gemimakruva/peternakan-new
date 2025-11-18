<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class Peternakan extends Model
{

    protected $table = 'peternakan';

    protected $fillable = [
        'nama',
        'lokasi'
    ];

    /**
     * Relasi: Satu peternakan memiliki banyak kandang
     */
    public function kandang()
    {
        return $this->hasMany(Kandang::class, 'peternakan_id', 'id');
    }
}
