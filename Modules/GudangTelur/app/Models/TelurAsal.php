<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class TelurAsal extends Model
{
    public $table = 'telur_asal';

    protected $fillable = [
        'nama',
    ];
}
