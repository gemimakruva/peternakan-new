<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\GudangPakan\Database\Factories\BahanPakanMasukFactory;

class BahanPakanMasuk extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): BahanPakanMasukFactory
    // {
    //     // return BahanPakanMasukFactory::new();
    // }
}
