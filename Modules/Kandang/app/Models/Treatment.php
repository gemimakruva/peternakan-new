<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    public $table = 'treatment';

    protected $fillable = [
        'kandang_id',
        'tanggal',
        'user_creator_id',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function userCreator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function treatmentJadwal()
    {
        return $this->hasMany(TreatmentJadwal::class, 'treatment_id', 'id');
    }
}
