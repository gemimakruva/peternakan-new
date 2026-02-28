<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class TelurTujuan extends Model
{
    public $table = 'telur_tujuan';

    protected $fillable = [
        'nama',
    ];
}
