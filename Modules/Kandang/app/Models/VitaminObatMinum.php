<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class VitaminObatMinum extends Model
{
    use HasFactory;

    protected $table = 'vitamin_obat_minum';

    protected $fillable = [
        'flock_id',
        'jenis_treatment_id',
        'tanggal',
        'merk_ovk',
        'dosis_pemberian',
        'satuan_per_dosis',
        'air_minum_per_ekor',
        'jumlah_ayam_per_baris',
        'jumlah_air_di_tong_per_baris',
    ];

    public function JenisTreatment(): BelongsTo
    {
        return $this->belongsTo(JenisTreatment::class, 'jenis_treatment_id');
    }

    public function flock(): BelongsTo
    {
        return $this->belongsTo(Flock::class, 'flock_id');
    }

    public function kandang(): HasOneThrough
    {
        return $this->hasOneThrough(
            Kandang::class,
            Flock::class,
            'id',
            'id',
            'flock_id',
            'kandang_id'
        );
    }
}
