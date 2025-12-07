<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class SamplingBobotAyam extends Model
{

    protected $table = 'sampling_bobot_ayam';

    protected $fillable = [
        'tanggal',
        'kandang_id',
        'umur',
        'jumlah_ayam_saat_ini',
        'jumlah_ayam_yang_disampling',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];


    /**
    * Sampling bobot ayam milik satu kandang
    */
    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    /**
    * Berat badan rata-rata per ekor milik satu sampling bobot ayam
    */
    public function beratBadanRataRataPerEkor()
    {
        return $this->hasMany(SamplingBobotAyamPerEkor::class, 'sampling_bobot_ayam_id', 'id');
    }
}
