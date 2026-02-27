<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class KemasanOutput extends Model
{
    public $table = 'kemasan_output';

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
        return $this->hasMany(KemasanInventory::class, 'kemasan_output_id');
    }
}
