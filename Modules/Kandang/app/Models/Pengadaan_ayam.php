<?php

namespace Modules\Kandang\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Pengadaan_ayam extends Model
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
        'jumlah ayam_masuk_kandang',
        'catatan'
    ];

    public function pic_user(){
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function berkasSupplier()
    {
        return $this->hasMany(BerkasPengadaanAyam::class, 'pengadaan_ayam_id', 'id');
    }

    
}
