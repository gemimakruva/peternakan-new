<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class OvkPakan extends Model
{
    use HasFactory;
    protected $table = 'ovk_pakan';
    protected $fillable = [
        'tanggal',
        'kandang_id',
        'flock_id',
        'merk_ovk',
        'Dosis_OVK',
        'total_kebutuhan_pakan',
        'waktu_pemberian_pakan',
        'proposi_pemberian_pagi',
        'proposi_pemberian_sore',
        'perhitungan_kebutuhan_pakan_pagi',
        'perhitungan_kebutuhan_pakan_sore',
        'perhitungan_kebutuhan_ovk'
    ];

    public function flock(){
        return $this->belongsTo(Flock::class,'flock_id');
    }

     protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\OvkPakanFactory::new();
    }

}
