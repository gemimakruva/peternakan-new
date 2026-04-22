<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanFinishedGoodOpname extends Model
{
    public $table = 'pakan_finished_good_opname';

    protected $fillable = [
        'pic_user_id',
        'tanggal',
    ];
    
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pakanFinishedGoodInventory()
    {
        return $this->hasMany(PakanFinishedGoodInventory::class, 'pakan_finished_good_opname_id', 'id');
    }
}
