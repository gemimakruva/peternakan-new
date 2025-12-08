<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerhitunganPakan extends Model
{
    use HasFactory;

    protected $table = "perhitungan_pakan";

    protected $fillable = [
        'tanggal_pemberian_pakan',
        'user_creator_id',     
        'user_executor_id',      
        'jenis_pakan_id',
        'pipe_id',
        'proporsi_pemberian_pagi',
        'proporsi_pemberian_sore',
        'waktu_pemberian_pagi',
        'waktu_pemberian_sore',
        'jumlah_ayam_per_pipe',
        'jumlah_pakan_per_ekor_gram',
        'catatan',
    ];

    /**
     * Relasi ke JenisPakan
     */
    public function jenis_pakan()
    {
        return $this->belongsTo(JenisPakan::class, 'jenis_pakan_id');
    }

    public function pipe()
    {
          return $this->belongsTo(Pipe::class, 'pipe_id');
    }


    /**
     * Tentukan factory untuk model modular ini
     */
    protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\PerhitunganPakanFactory::new();
    }
}
