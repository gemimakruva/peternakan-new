<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class BahanPakanOpname extends Model
{
    public $table = 'bahan_pakan_opname';

    protected $fillable = [
        'pic_user_id',
        'tanggal',
    ];
    
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function bahanPakanInventory()
    {
        return $this->hasMany(BahanPakanInventory::class, 'bahan_pakan_opname_id', 'id');
    }
}
