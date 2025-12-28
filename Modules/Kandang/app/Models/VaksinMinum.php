<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class VaksinMinum extends Model
{

    protected $table = 'vaksin_minum';

    protected $fillable = [
        'flock_id',
        'tanggal',
        'nama_vaksin',
        'total_dosis',
        'air_minum_per_ekor',
        'jumlah_ayam_per_baris',
        'jumlah_ml_vaksin_per_baris',
        'jumlah_air_di_tong_per_baris',
    ];

    /**
     * Vaksin Minum milik satu flock
     */
    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

}
