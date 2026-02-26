<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class KemasanInput extends Model
{
    public $table = 'kemasan_input';

    protected $fillable = [
        'pic_user_id',
        'supplier_id',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'datetime',
    ];

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }

    public function supplier()
    {
        return $this->belongsTo(SupplierKemasan::class, 'supplier_id');
    }

    public function dokumentasi()
    {
        return $this->hasMany(KemasanInputDokumentasi::class, 'kemasan_input_id');
    }

    public function kemasanInventory()
    {
        return $this->hasMany(KemasanInventory::class, 'kemasan_input_id');
    }
}
