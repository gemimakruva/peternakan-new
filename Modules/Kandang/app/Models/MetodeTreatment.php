<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MetodeTreatment extends Model
{
    use HasFactory;

    protected $table = 'metode_treatment'; 

    protected $fillable = [
        'nama'
    ];

    protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\MetodeTreatmentFactory::new();
    }
}
