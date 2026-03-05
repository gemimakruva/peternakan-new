<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\GudangPakan\Database\Factories\BahanPakanOpnameFactory;

class BahanPakanOpname extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): BahanPakanOpnameFactory
    // {
    //     // return BahanPakanOpnameFactory::new();
    // }
}
