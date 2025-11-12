<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Kandang\Database\Factories\KandangFactory;

class Kandang extends Model
{
    use HasFactory;

    public $table = 'kandang';
    
    protected $fillable = [
        'nama',
        'alamat',
    ];

    public function flocks()
    {
        return $this->hasMany(Flock::class, 'kandang_id', 'id');
    }

    protected static function newFactory(): KandangFactory
    {
        return KandangFactory::new();
    }
}
