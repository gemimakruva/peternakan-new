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
        return $this->belongsTo(Pengadaan_ayam::class, 'pengadaan_ayam_id');
    }

    /**
     * Relasi ke Kandang
     */
    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    /**
     * Relasi ke Flock
     */
    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id');
    }

    /**
     * Relasi ke Pipe
     */
    public function pipe()
    {
        return $this->belongsTo(Pipe::class, 'pipe_id');
    }

}
