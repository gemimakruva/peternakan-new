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

    /**
     * Relasi ke Pipe
     */
    public function pipe()
    {
        return $this->belongsTo(Pipe::class, 'pipe_id');
    }

}
