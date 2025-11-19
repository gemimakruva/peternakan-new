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

    /**
     * Relasi ke flock
     */
    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

    /**
     * Relasi ke log populasi
     */
    public function populationLogs()
    {
        return $this->hasMany(SupplierLog::class, 'pipe_id');
    }

    /**
     * Accessor: Mendapatkan nama flock
     */
    public function getFlockNameAttribute()
    {
        return $this->flock->flock_name ?? '-';
    }

    /**
     * Accessor: Mendapatkan nama kandang dari flock
     */
    public function getKandangNameAttribute()
    {
        return $this->flock->kandang->name ?? '-';
    }
}
