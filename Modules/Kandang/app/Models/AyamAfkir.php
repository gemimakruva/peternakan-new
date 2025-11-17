<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AyamAfkir extends Model
{
    use HasFactory;

    protected $table = 'ayam_afkir';

    protected $fillable = [
        'tanggal_afkir',
        'kandang_id',
        'flock_id',
        'pipe_id',
        'umur_ayam',
        'jumlah_ayam_afkir',
        'penyebab_afkir',
        'nama_pembeli',
        'harga_jual_per_kg',
    ];

    // Relasi ke Kandang
    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    // Relasi ke Flock
    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id');
    }
}
