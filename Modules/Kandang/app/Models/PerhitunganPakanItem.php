<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Kandang\Database\Factories\PerhitunganPakanItemFactory;

class PerhitunganPakanItem extends Model
{
    use HasFactory;

    public $table = 'perhitungan_pakan_item';

    protected $fillable = [
        'perhitungan_pakan_id',
        'kandang_id',
        'flock_id',
        'pipe_id',
        'tanggal_pemberian_pakan',
        'jumlah_ayam',
        'pemberian_pakan_per_ekor' // gram
    ];

    protected $casts = [
        'tanggal_pemberian_pakan' => 'date',
    ];

    public function perhitunganPakan()
    {
        return $this->belongsTo(PerhitunganPakan::class, 'perhitungan_pakan_id');
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
}
