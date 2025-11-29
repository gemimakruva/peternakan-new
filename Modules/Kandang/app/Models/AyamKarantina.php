<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AyamKarantina extends Model
{
    use HasFactory;

    protected $table = 'ayam_karantina';

    protected $fillable = [
        'pic_user_id',
        'populasi_ayam_id',
        'tanggal_karantina',
        'ayam_masuk_karantina',
        'keterangan_pengecekan',
        'ayam_mati',
        'ayam_afkir',
        'ayam_keluar_karantina',
        'pemberian_pakan',
        'sisa_pakan',
        'jumlah_telur_bagus',
        'jumlah_telur_retak',
        'jumlah_telur_rusak',
        'pengobatan_yang_dilakukan',
        'jumlah_ayam_diobati',
        'penyemprotan',
        'vaksin',
        'catatan',
    ];

     public function populasi()
    {
        return $this->belongsTo(PopulasiAyam::class, 'populasi_ayam_id');
    }

    public function pic_user()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }
}
