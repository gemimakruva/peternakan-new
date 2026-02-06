<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ProduksiTelur extends Model
{
    protected $table = 'produksi_telur';

    protected $fillable = [
        'kandang_id',
        'pic_user_id',
        'tanggal',
        'umur_ayam',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function produksiTelurItems()
    {
        return $this->hasMany(ProduksiTelurItem::class, 'produksi_telur_id', 'id');
    }
}
