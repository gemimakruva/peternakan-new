<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\GudangTelur\Database\Factories\KemasanFactory;

class Kemasan extends Model
{
    public $table = 'kemasan';

    protected $fillable = [
        'satuan_id',
        'nama',
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }
}
