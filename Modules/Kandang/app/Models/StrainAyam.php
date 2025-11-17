<?php
namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrainAyam extends Model
{
    use HasFactory;

    protected $table = 'strain_ayam';

    protected $fillable = [
        'strain',
        'umur_minggu',
        'bb_bawah',
        'bb_atas',
        'bb_rata2',
        'persentase_kematian',
        'feed_intake',
        'fcr',
        'hdp',
        'hhp',
        'egg_weight',
        'egg_mass',
    ];
}
