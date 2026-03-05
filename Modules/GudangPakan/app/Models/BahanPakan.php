<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangTelur\Enums\BahanPakanTipe;
use Modules\GudangTelur\Models\Satuan;

class BahanPakan extends Model
{
    public $table = 'bahan_pakan';

    protected $fillable = [
        'satuan_id',
        'nama',
        'tipe',
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function getTipeEnumAttribute()
    {
        if (!$this->attributes['tipe']) return null;
        return BahanPakanTipe::tryFrom($this->attributes['tipe']);
    }
}
