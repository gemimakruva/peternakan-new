<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PenjadwalanDisinfektan extends Model
{
    use HasFactory;

    protected $table = 'penjadwalan_disinfektan';

    protected $fillable = [
        'kandang_id',
        'pic_user_id',
        'tanggal',
        'detail_waktu',
    ];

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function picUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pic_user_id');
    }

    public function penjadwalanFlock(): HasMany
    {
        return $this->hasMany(PenjadwalanDisinfektanFlock::class, 'penjadwalan_disinfektan_id');
    }
}
