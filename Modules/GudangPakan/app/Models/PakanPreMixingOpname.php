<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanPreMixingOpname extends Model
{
    public $table = 'pakan_pre_mixing_opname';

    protected $fillable = [
        'pic_user_id',
        'tanggal',
    ];
    
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pakanPreMixingInventory()
    {
        return $this->hasMany(PakanPreMixingInventory::class, 'pakan_pre_mixing_opname_id', 'id');
    }
}
