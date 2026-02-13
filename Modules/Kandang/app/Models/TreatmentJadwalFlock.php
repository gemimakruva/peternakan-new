<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TreatmentJadwalFlock extends Model
{
    public $table = 'treatment_jadwal_flock';

    protected $fillable = [
        'treatment_jadwal_id',
        'flock_id',
        'executed_at',
        'executed_by',
    ];

    protected $casts = [
        'executed_at'   => 'datetime'
    ];

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id');
    }

    public function executedBy()
    {
        return $this->belongsTo(User::class, 'executed_by');
    }
}
