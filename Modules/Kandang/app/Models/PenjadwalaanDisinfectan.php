<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Models\Kandang;

class PenjadwalaanDisinfectan extends Model
{
    /** @use HasFactory<\Database\Factories\PenjadwalaanDisinfectanFactory> */
    use HasFactory;

     protected $table = 'penjadwalaan_disinfectan';

    protected $fillable = [
    'kandang_id',
    'jenis_disinfectan_id',
    'pic_user_id',
    'tanggal',
    'detail_waktu',
    'is_all_flock',
    'area',
    'merk_disinfektan',
    'dosisi_per_tangki',
];

public function kandang()
{
    return $this->belongsTo(Kandang::class, 'kandang_id');
}

// public function jenisDisinfectan()
// {
//     return $this->belongsTo(JenisDisinfectan::class, 'jenis_disinfectan_id');
// }

    
}
