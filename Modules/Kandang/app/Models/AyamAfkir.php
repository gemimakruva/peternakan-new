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
        'kandang_id',
        'pic_user_id',
        'tanggal',
        'umur_ayam',
        'penyebab_afkir', 
        'pembeli_afkir', 
        'harga_jual',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];
    
    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function ayamAfkirPopulasi()
    {
        return $this->hasMany(AyamAfkirPopulasi::class, 'ayam_afkir_id', 'id');
    }
}
