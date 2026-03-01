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

    protected $casts = [
        'tanggal'    => 'date'
    ];

    public function telurInventory()
    {
        return $this->hasOne(TelurInventory::class, 'telur_opname_id', 'id');
    }
}
