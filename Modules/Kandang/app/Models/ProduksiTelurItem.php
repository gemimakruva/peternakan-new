<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;

class ProduksiTelurItem extends Model
{
    protected $table = 'produksi_telur_item';

    protected $fillable = [
        'produksi_telur_id',
        'kandang_id',
        'flock_id',
        'tanggal',
        'jumlah_telur_bagus',
        'jumlah_telur_putih',
        'jumlah_telur_reject',
        'berat_telur_bagus',
        'berat_telur_putih',
        'berat_telur_reject',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function produksiTelur()
    {
        return $this->belongsTo(ProduksiTelur::class, 'produksi_telur_id');
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

    public function getTotalJumlahTelurAttribute()
    {
        return $this->jumlah_telur_bagus + $this->jumlah_telur_putih + $this->jumlah_telur_reject;
    }

    public function getTotalBeratTelurAttribute()
    {
        return $this->berat_telur_bagus + $this->berat_telur_putih + $this->berat_telur_reject;
    }
}
