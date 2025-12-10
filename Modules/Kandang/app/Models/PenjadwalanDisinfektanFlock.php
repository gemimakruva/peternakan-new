<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenjadwalanDisinfektanFlock extends Model
{
    use HasFactory;

    protected $table = 'penjadwalan_disinfektan_flock';

    protected $fillable = [
        'penjadwalan_disinfektan_id',
        'jenis_disinfektan_id',
        'flock_id',
        'area',
        'merk_disinfektan',
        'dosis_per_tangki',
    ];

    public function penjadwalan(): BelongsTo
    {
        return $this->belongsTo(PenjadwalanDisinfektan::class, 'penjadwalan_disinfektan_id');
    }

    public function jenisDisinfektan(): BelongsTo
    {
        return $this->belongsTo(JenisDisinfektan::class, 'jenis_disinfektan_id');
    }

    public function flock(): BelongsTo
    {
        return $this->belongsTo(Flock::class, 'flock_id');
    }
}
