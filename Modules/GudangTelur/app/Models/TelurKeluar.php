<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\GudangTelur\Database\Factories\TelurKeluarFactory;

class TelurKeluar extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): TelurKeluarFactory
    // {
    //     // return TelurKeluarFactory::new();
    // }
}
