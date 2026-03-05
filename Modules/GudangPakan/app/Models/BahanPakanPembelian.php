<?php

namespace Modules\GudangPakan\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BahanPakanPembelian extends Model
{
    public $table = 'bahan_pakan_pembelian';

    protected $fillable = [
        'pic_user_id',
        'supplier_id',
        'tanggal_pesan',
        'tanggal_datang',
    ];

    protected $casts = [
        'tanggal_pesan'     => 'date',
        'tanggal_datang'    => 'date',
    ];

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id', 'id');
    }

    public function bahanPakanPembelianItem()
    {
        return $this->hasMany(BahanPakanPembelianItem::class, 'bahan_pakan_pembelian_id', 'id');
    }
}
