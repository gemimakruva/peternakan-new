<?php

namespace Modules\Kandang\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PengadaanAyam extends Model
{
    protected $table = 'pengadaan_ayam';

    protected $fillable = [
        'pic_user_id',
        'tanggal',
        'umur_ayam',
        'kondisi_ayam',
        'jumlah_ayam_datang',
        'jumlah_ayam_mati',
        'jumlah_ayam_sakit',
        'jumlah_ayam_masuk_kandang',
        'catatan'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pic_user(){
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function berkasSupplier()
    {
        return $this->hasMany(BerkasPengadaanAyam::class, 'pengadaan_ayam_id', 'id');
    }

    public function distribusi()
    {
            return $this->hasMany(PengadaanAyamDistribusi::class, 
            'pengadaan_ayam_id', 'id');
    }

    public function dokumentasi()
    {
            return $this->hasMany(PengadaanAyamDokumentasi::class, 
            'pengadaan_ayam_id', 'id');
    }


    
}
