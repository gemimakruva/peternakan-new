<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Models\Kandang;

class PenjadwalanTreatment extends Model
{
    use HasFactory;

    protected $table = 'penjadwalan_treatment';

    protected $fillable = [
        'id',
        'kandang_id', 
        'pic_user_id',
        'tanggal',
        'detail_waktu'
    ];

    public function picUser()
    {
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }

    public function treatmentFlocks()
    {
        return $this->hasMany(
            PenjadwalanTreatmentFlock::class,
            'penjadwalan_treatment_id', 
            'id'                         
        );
    }
    protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\PenjadwalanTreatmentFactor::new();
    }
}
