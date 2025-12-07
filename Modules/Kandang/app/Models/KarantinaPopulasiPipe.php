<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class KarantinaPopulasiPipe extends Model
{
    protected $table = 'karantina_populasi_pipe';

    protected $fillable = [
        'populasi_ayam_asal_id',
        'tanggal',
        'pipe_asal_id',
        'ayam_masuk_karantina',
        'pipe_tujuan_id',
        'ayam_keluar_karantina',
    ];

    public function populasiAyamAsal()
    {
        return $this->belongsTo(PopulasiAyam::class, 'populasi_ayam_asal_id', 'id');
    }

    public function pipeAsal()
    {
        return $this->belongsTo(Pipe::class, 'pipe_asal_id', 'id');
    }

    public function pipeTujuan()
    {
        return $this->belongsTo(Pipe::class, 'pipe_tujuan_id', 'id');
    }
}
