<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AyamAfkirPopulasi extends Model
{
    use HasFactory;

    protected $table = 'ayam_afkir_populasi';

    protected $fillable = [
        'ayam_afkir_id',
        'populasi_ayam_id',
        'pipe_id',
        'flock_id',
        'kandang_id',
        'pic_user_id',
        'tanggal',
        'jumlah_ayam_afkir',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function ayamAfkir()
    {
        return $this->belongsTo(AyamAfkir::class, 'ayam_afkir_id', 'id');
    }
    
    public function populasiAyam()
    {
        return $this->belongsTo(PopulasiAyam::class, 'populasi_ayam_id', 'id');
    }

    public function pipe()
    {
        return $this->belongsTo(Pipe::class, 'pipe_id', 'id');
    }

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    } 

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }
}
