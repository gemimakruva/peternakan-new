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
        'kandang_id',
        'flock_id',
        'pipe_id',
        'ayam_sehat',
        'ayam_mati',
        'ayam_afkir',
        'ayam_masuk_karantina',
        'ayam_keluar_karantina',
        'catatan',
    ];

    

      public function pengadaanDistribusi()
    {
        return $this->belongsTo(PengadaanAyamDistribusi::class,
         'pengadaan_ayam_distribusi_id');
    }

     public function pic_user()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }

      public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

      public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id');
    }

     public function pipe()
    {
        return $this->belongsTo(Pipe::class, 'pipe_id');
    }

}
