<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AyamAfkir extends Model
{
    use HasFactory;

    protected $table = 'ayam_afkir';

    protected $fillable = [
        'populasi_ayam_id',
        'pic_user_id',
        'tanggal',
        'umur_ayam',
        'jumlah_ayam_afkir',
        'penyebab_afkir',
        'pembeli_afkir',
        'harga_jual'
    ];

    // Relasi ke Kandang
   public function populasi()
   {
    return $this->belongsTo(PopulasiAyam::class,'populasi_ayam_id','id');
   }

    public function pic_user()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }
}
