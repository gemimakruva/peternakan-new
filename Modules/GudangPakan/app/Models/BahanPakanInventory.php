<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\GudangPakan\Database\Factories\BahanPakanInventoryFactory;

class BahanPakanInventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): BahanPakanInventoryFactory
    // {
    //     // return BahanPakanInventoryFactory::new();
    // }
}
