<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PemberianPakanSisaPakan extends Model
{
    protected $table = 'pemberian_pakan_sisa_pakan';

    protected $fillable = [
        'perhitungan_pakan_id',
        'flock_id',
        'sisa_pakan_per_flock_kg',
    ];

    public function perhitunganPakan()
    {
        return $this->belongsTo(PerhitunganPakan::class, 'perhitungan_pakan_id', 'id');
    }

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }
}
