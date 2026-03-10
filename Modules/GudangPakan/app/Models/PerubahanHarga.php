<?php

namespace Modules\GudangPakan\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class PerubahanHarga extends Model
{
    public $table = 'perubahan_harga';

    protected $fillable = [
        'pic_user_id',
        'harga',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }
}
