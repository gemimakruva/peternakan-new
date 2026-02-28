<?php

namespace Modules\GudangTelur\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TelurMasuk extends Model
{
    public $table = 'telur_masuk';

    protected $fillable = [
        'telur_asal_id',
        'pic_user_id',
        'tanggal',
    ];

    protected $casts = [
        'tanggal'   => 'date',
    ];

    public function telurAsal()
    {
        return $this->belongsTo(TelurAsal::class, 'telur_asal_id', 'id');
    }

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function telurInventory()
    {
        return $this->hasMany(TelurInventory::class, 'telur_masuk_id', 'id');
    }
}
