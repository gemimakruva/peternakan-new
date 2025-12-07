<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class SamplingBobotAyamPerEkor extends Model
{

    protected $table = 'sampling_bobot_ayam_per_ekor';

    protected $fillable = [
        'sampling_bobot_ayam_id',
        'bobot_per_kg',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    
    /**
    * Sampling bobot ayam milik satu kandang
    */
    public function samplingBobotAyam()
    {
        return $this->belongsTo(SamplingBobotAyam::class, 'sampling_bobot_ayam_id');
    }
}
