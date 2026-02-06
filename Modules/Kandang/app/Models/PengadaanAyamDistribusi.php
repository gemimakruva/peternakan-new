<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengadaanAyamDistribusi extends Model
{
    use HasFactory;

    protected $table = 'pengadaan_ayam_distribusi';

    // Mass assignable fields
    protected $fillable = [
        'pengadaan_ayam_id',
        'kandang_id',
        'flock_id',
        'pipe_id',
        'jumlah_ayam',
    ];

    /**
     * Relasi ke PengadaanAyam
     */
    public function pengadaanAyam()
    {
        return $this->belongsTo(PengadaanAyam::class, 'pengadaan_ayam_id');
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id');
    }
    
    public function pipe()
    {
        return $this->belongsTo(Pipe::class, 'pipe_id');
    }

    public function populasiAyam()
    {
        return $this->hasOne(PopulasiAyam::class, 'pengadaan_ayam_distribusi_id', 'id');
    }

    public function latestPopulasiAyam()
    {
        return $this->hasOne(PopulasiAyam::class, 'pipe_id', 'pipe_id')->latest()->limit(1);
    }

}
