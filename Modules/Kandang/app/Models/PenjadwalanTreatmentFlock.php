<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjadwalanTreatmentFlock extends Model
{
    protected $table = 'penjadwalan_treatment_flock';
    use HasFactory;
    protected $fillable = [
    'penjadwalan_treatment_id',
    'flock_id',
    'jenis_treatment_id',
    'metode_treatment_id',
    'dosis_pemberian'
    ];

    public function PenjadwalaanTreatment()
    {
        return $this->belongsTo(PenjadwalanTreatment::class,
        'penjadwalan_treatment_id','id');
    }

    public function flock()
    {
         return $this->belongsTo(Flock::class,
        'flock_id','id');
    }

     public function jenisTreatment()
{
    return $this->belongsTo(JenisTreatment::class, 'jenis_treatment_id');
}

    public function metodeTreatment()
    {
        return  $this->belongsTo(MetodeTreatment::class,'metode_treatment_id','id');
    }

     protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\penjadwalanTreatmentFlockFactory::new();
    }

}
