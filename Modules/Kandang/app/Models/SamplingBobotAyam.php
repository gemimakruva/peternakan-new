<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SamplingBobotAyam extends Model
{
    protected $table = 'sampling_bobot_ayam';

    protected $fillable = [
        'pencatat_user_id',
        'tanggal',
        'kandang_id',
        'umur',
        'jumlah_ayam_saat_ini',
        'jumlah_ayam_yang_disampling',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pencatatUser()
    {
        return $this->belongsTo(User::class, 'pencatat_user_id');
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function samplingBobotAyamPerEkor()
    {
        return $this->hasMany(SamplingBobotAyamPerEkor::class, 'sampling_bobot_ayam_id', 'id');
    }
}
