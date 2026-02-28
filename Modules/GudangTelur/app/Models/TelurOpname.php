<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class TelurOpname extends Model
{
    public $table = 'telur_opname';

    protected $fillable = [
        'pic_user_id',
        'tanggal',
    ];
}
