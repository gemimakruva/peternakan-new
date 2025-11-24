<?php

namespace Modules\Kandang\Models;
use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Models\Pengadaan_ayam;
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
        return $this->belongsTo(Pengadaan_ayam::class, 'pengadaan_ayam_id', 'id');
    }
}
