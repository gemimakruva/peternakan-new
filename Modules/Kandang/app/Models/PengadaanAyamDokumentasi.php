<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Models\Pengadaan_ayam;

class PengadaanAyamDokumentasi extends Model
{
    protected $table = 'pengadaan_ayam_dokumentasi';

    protected $fillable = [
        'pengadaan_ayam_id',
        'file_path',
    ];

     public function pengadaanAyam()
    {
        return $this->belongsTo(Pengadaan_ayam::class,
         'pengadaan_ayam_id');
    }


}
