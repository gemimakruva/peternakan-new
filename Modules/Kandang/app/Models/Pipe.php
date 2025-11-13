<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Pipe extends Model
{
    use HasFactory;

    public $table = 'pipe';
    
    protected $fillable = [
        'flock_id',
        'pipe_name',
        'capacity',
        'inital_population'
    ];

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

    // protected static function newFactory(): PipeFactory
    // {
    //     // return PipeFactory::new();
    // }
    public function populationLogs()
{
    return $this->hasMany(SupplierLog::class, 'pipe_id');
}


public function getFlockNameAttribute()
{
    return $this->pipe->flock->flock_name ?? '-';
}

public function getKandangNameAttribute()
{
    return $this->pipe->flock->kandang->name ?? '-';
}


}
