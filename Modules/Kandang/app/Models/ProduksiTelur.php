<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProduksiTelur extends Model
{

    protected $table = 'produksi_telur';

    protected $fillable = [
        'flock_id',
        'pic_user_id',
        'tanggal',
        'usia_ayam',
        'jumlah_telur_bagus',
        'jumlah_telur_putih',
        'jumlah_telur_reject',
        'berat_telur_bagus',
        'berat_telur_putih',
        'berat_telur_reject',
    ];

    /**
     * Produksi telur milik satu flock
     */
    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

    /**
     * Produksi telur dicatat oleh satu user (PIC)
     */
    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    /**
     * Total jumlah telur
     */
    public function getTotalJumlahTelurAttribute()
    {
        return $this->jumlah_telur_bagus + $this->jumlah_telur_putih + $this->jumlah_telur_reject;
    }

    /**
     * Total berat telur
     */
    public function getTotalBeratTelurAttribute()
    {
        return $this->berat_telur_bagus + $this->berat_telur_putih + $this->berat_telur_reject;
    }

}
