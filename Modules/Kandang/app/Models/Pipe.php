<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pipe extends Model
{
    use HasFactory;

    protected $table = 'pipe';

    protected $fillable = [
        'flock_id',
        'nama',
        'kapasitas',
    ];

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

    public function populasiAyam()
    {
        return $this->hasMany(PopulasiAyam::class, 'pipe_id', 'id');
    }

    public function getFlockNameAttribute()
    {
        return $this->flock->flock_name ?? '-';
    }

    public function getKandangNameAttribute()
    {
        return $this->flock->kandang->name ?? '-';
    }

    public function pengadaanAyamDistribusi()
    {
        return $this->hasMany(PengadaanAyamDistribusi::class, 'pipe_id', 'id');
    }

    public function perhitunganPakan()
    {
        return $this->hasMany(PerhitunganPakan::class, 'pipe_id', 'id');
    }
}
