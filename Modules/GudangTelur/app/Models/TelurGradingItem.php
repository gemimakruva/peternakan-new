<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class TelurGradingItem extends Model
{
    public $table = 'telur_grading_item';

    protected $fillable = [
        'telur_grading_id',
        'telur_jenis_id',
        'jumlah',
    ];

    protected $casts = [
        'jumlah'    => 'integer',
    ];

    public function telurGrading()
    {
        return $this->belongsTo(TelurGrading::class, 'telur_grading_id', 'id');
    }

    public function telurJenis()
    {
        return $this->belongsTo(TelurJenis::class, 'telur_jenis_id', 'id');
    }
}
