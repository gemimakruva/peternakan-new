<?php

namespace Modules\GudangTelur\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class TelurKeluar extends Model
{
    public $table = 'telur_keluar';

    protected $fillable = [
        'telur_tujuan_id',
        'kemasan_output_id',
        'pic_user_id',
        'tanggal',
    ];

    protected $casts = [
        'tanggal'   => 'date',
    ];

    public function telurTujuan()
    {
        return $this->belongsTo(TelurTujuan::class, 'telur_tujuan_id', 'id');
    }

    public function kemasanOutput()
    {
        return $this->belongsTo(KemasanOutput::class, 'kemasan_output_id', 'id');
    }

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function telurInventory()
    {
        return $this->hasMany(TelurInventory::class, 'telur_keluar_id', 'id');
    }
}
