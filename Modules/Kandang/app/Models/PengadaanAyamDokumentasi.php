<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Models\PengadaanAyam;

class PengadaanAyamDokumentasi extends Model
{
    protected $table = 'pengadaan_ayam_dokumentasi';

    protected $fillable = [
        'pengadaan_ayam_id',
        'file_path',
    ];

    public function pengadaanAyam()
    {
        return $this->belongsTo(PengadaanAyam::class,
         'pengadaan_ayam_id');
    }
}
