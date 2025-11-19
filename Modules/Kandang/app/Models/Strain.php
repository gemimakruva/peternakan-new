<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Strain extends Model
{
    use SoftDeletes; 
    protected $table = 'strain';

     protected $fillable = [
        'id',
        'created_at',
        'updated_at',
    ];
    protected $dates = ['deleted_at'];

     public function metrics()
    {
        return $this->hasMany(StrainStandartMetric::class, 'strain_id');
    }

    public function kandang()
    {
        return $this->hasMany(Kandang::class, 'strain_id', 'id');
    }
}
