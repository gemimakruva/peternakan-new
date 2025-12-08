<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Flock extends Model
{
    use HasFactory;

    public $table = 'flock';

    protected $fillable = [
        'kandang_id',
        'nama',
        'kapasitas',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }

    public function pipes()
    {
        return $this->hasMany(Pipe::class, 'flock_id', 'id');
    }

    public function pemberianPakanSisaPakan()
    {
        return $this->hasMany(PemberianPakanSisaPakan::class, 'flock_id', 'id');
    }


}
