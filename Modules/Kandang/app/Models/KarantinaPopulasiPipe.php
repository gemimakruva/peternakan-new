<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class KarantinaPopulasiPipe extends Model
{
    protected $table = 'karantina_populasi_pipe';

    protected $fillable = [
        'populasi_ayam_asal_id',
        'tanggal',
        'kandang_asal_id',
        'flock_asal_id',
        'pipe_asal_id',
        'ayam_masuk_karantina',
        'kandang_tujuan_id',
        'flock_tujuan_id',
        'pipe_tujuan_id',
        'ayam_keluar_karantina',
    ];

    public function populasiAyamAsal()
    {
        return $this->belongsTo(PopulasiAyam::class, 'populasi_ayam_asal_id', 'id');
    }

    public function kandangAsal()
    {
        return $this->belongsTo(Kandang::class, 'kandang_asal_id', 'id');
    }

    public function flockAsal()
    {
        return $this->belongsTo(Flock::class, 'flock_asal_id', 'id');
    }

    public function pipeAsal()
    {
        return $this->belongsTo(Pipe::class, 'pipe_asal_id', 'id');
    }

    public function kandangTujuan()
    {
        return $this->belongsTo(Kandang::class, 'kandang_tujuan_id', 'id');
    }

    public function flockTujuan()
    {
        return $this->belongsTo(Flock::class, 'flock_tujuan_id', 'id');
    }

    public function pipeTujuan()
    {
        return $this->belongsTo(Pipe::class, 'pipe_tujuan_id', 'id');
    }
}
