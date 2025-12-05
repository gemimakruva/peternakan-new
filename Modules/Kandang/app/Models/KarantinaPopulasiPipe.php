<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KarantinaPopulasiPipe extends Model
{
    protected $table = 'karantina_populasi_pipe';

    protected $fillable = [
        'pipe_asal_id',
        'ayam_masuk_karantina',
        'pipe_tujuan_id',
        'ayam_keluar_karantina',
    ];

    public function pipeAsal()
    {
        return $this->belongsTo(Pipe::class, 'pipe_asal_id', 'id');
    }

    public function pipeTujuan()
    {
        return $this->belongsTo(Pipe::class, 'pipe_tujuan_id', 'id');
    }
}
