<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Kandang\Database\Factories\FlockFactory;

class Flock extends Model
{
    use HasFactory;

    public $table = 'flock';

    protected $fillable = [
        'kandang_id',
        'nama',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }

    public function pipe()
    {
        return $this->hasMany(Pipe::class, 'flock_id', 'id');
    }

    // protected static function newFactory(): FlockFactory
    // {
    //     // return FlockFactory::new();
    // }
}
