<?php

namespace Modules\GudangTelur\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Models\Kandang;

class TelurGrading extends Model
{
    public $table = 'telur_grading';

    protected $fillable = [
        'pic_user_id',
        'kandang_id',
        'tanggal',
    ];

    protected $casts = [
        'tanggal'   => 'date',
    ];

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function telurGradingItems()
    {
        return $this->hasMany(TelurGradingItem::class, 'telur_grading_id', 'id');
    }
}
