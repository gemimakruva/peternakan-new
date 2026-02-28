<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class TelurJenis extends Model
{
    public $table = 'telur_jenis';

    protected $fillable = [
        'tipe',
        'nama'
    ];
}
