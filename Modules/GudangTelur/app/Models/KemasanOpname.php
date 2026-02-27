<?php

namespace Modules\GudangTelur\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class KemasanOpname extends Model
{
    public $table = 'kemasan_opname';

    protected $fillable = [
        'pic_user_id',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }

    public function kemasanInventory()
    {
        return $this->hasMany(KemasanInventory::class, 'kemasan_opname_id');
    }
}
