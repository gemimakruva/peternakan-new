<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\BahanPakanKeluarTujuan;

class BahanPakanKeluar extends Model
{
    public $table = 'bahan_pakan_keluar';

    protected $fillable = [
        'pic_user_id',
        'tujuan',
        'tanggal',
    ];

    protected $casts = [
        'tujuan' => BahanPakanKeluarTujuan::class,
        'tanggal' => 'date',
    ];

    public function bahanPakanInventory()
    {
        return $this->hasMany(BahanPakanInventory::class, 'bahan_pakan_keluar_id', 'id');
    }
}
