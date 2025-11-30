<?php

namespace Modules\Kandang\Models;
use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Models\PengadaanAyam;
class BerkasPengadaanAyam extends Model
{
    protected $table = 'pengadaan_ayam_berkas_supplier';

    protected $fillable = [
        'pengadaan_ayam_id',
        'file_path',
        'nama_berkas',
    ];

    public function pengadaanAyam()
    {
        return $this->belongsTo(PengadaanAyam::class,
         'pengadaan_ayam_id', 'id');
    }
}
