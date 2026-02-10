<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TreatmentJadwal extends Model
{
    public $table = 'treatment_jadwal';

    protected $fillable = [
        'treatment_id',
        'jenis_treatment_id',
        'metode_treatment_id',
        'merk_ovk',
        'area',
        'dosis',
        'waktu',
        'executed_at',
        'executed_by',
    ];

    protected $casts = [
        'waktu'         => 'datetime:H:i',
        'executed_at'   => 'datetime'
    ];

    public function treatmentJadwalFlocks()
    {
        return $this->hasMany(TreatmentJadwalFlock::class, 'treatment_jadwal_id', 'id');
    }

    public function executedBy()
    {
        return $this->belongsTo(User::class, 'executed_by');
    }
}
