<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PopulasiAyam extends Model
{
    protected $table = 'populasi_ayam';

    protected $fillable = [
        'pengadaan_ayam_distribusi_id',
        'jenis_pemeriksaan',
        'pic_user_id',
        'tanggal',
        'pipe_id',
        'umur_ayam_record',
        'ayam_sehat',
        'ayam_mati',
        'ayam_afkir',
        'ayam_masuk_karantina',
        'ayam_keluar_karantina',
        'catatan',
    ];

    public function karantinaPopulasiPipe()
    {
        return $this->hasOne(KarantinaPopulasiPipe::class, 'populasi_ayam_asal_id', 'id');
    }

    public function pengadaanDistribusi()
    {
        return $this->belongsTo(PengadaanAyamDistribusi::class, 'pengadaan_ayam_distribusi_id');
    }

    public function pic_user()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }

    public function pipe()
    {
        return $this->belongsTo(Pipe::class, 'pipe_id');
    }

    public static function getAyamSehatTerakhir($pipeId)
    {
        return self::getQuery()
            ->where('pipe_id', '=', $pipeId)
            ->orderByDesc('tanggal')
            ->orderByDesc('id')
            ->value('ayam_sehat');
    }
}
