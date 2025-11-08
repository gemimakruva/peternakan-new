<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Kandang\Database\Factories\PipeFactory;

class Pipe extends Model
{
    use HasFactory;

    public $table = 'pipe';
    
    protected $fillable = [
        'flock_id',
        'nama',
    ];

    public function flock()
    {
        return $this->belongsTo(Flock::class, 'flock_id', 'id');
    }

    // protected static function newFactory(): PipeFactory
    // {
    //     // return PipeFactory::new();
    // }
}
