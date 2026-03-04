<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangTelur\Enums\BahanBakuTipe;

class BahanBaku extends Model
{
    public $table = 'bahan_baku';

    protected $fillable = [
        'nama',
        'tipe',
    ];

    public function getTipeEnumAttribute()
    {
        if (!$this->attributes['tipe']) return null;
        return BahanBakuTipe::tryFrom($this->attributes['tipe']);
    }
}
