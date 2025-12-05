<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KarantinaPopulasi extends Model
{
    use HasFactory;

    protected $table = 'karantina_populasi';

    protected $fillable = [
        'kandang_id',
        'pic_user_id',
        'total_ayam_karantina',
        'tanggal',
        'ayam_mati',
        'ayam_afkir',
        'pemberian_pakan',
        'sisa_pakan',
        'jumlah_telur_bagus',
        'jumlah_telur_retak',
        'jumlah_telur_rusak',
        'berat_telur_bagus',
        'berat_telur_retak',
        'berat_telur_rusak',
        'pengobatan_yang_dilakukan',
        'jumlah_ayam_diobati',
        'penyemprotan',
        'vaksin',
        'catatan',
    ];

    

     public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function pic_user()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }
}
