<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\GudangPakan\Database\Factories\BahanPakanFormulasiFactory;

class BahanPakanFormulasi extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): BahanPakanFormulasiFactory
    // {
    //     // return BahanPakanFormulasiFactory::new();
    // }
}
