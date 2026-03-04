<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangTelur\Enums\BahanPakanTipe;

class BahanPakan extends Model
{
    public $table = 'bahan_pakan';

    protected $fillable = [
        'nama',
        'tipe',
    ];

    public function getTipeEnumAttribute()
    {
        if (!$this->attributes['tipe']) return null;
        return BahanPakanTipe::tryFrom($this->attributes['tipe']);
    }
}
