<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class KemasanInputDokumentasi extends Model
{
    public $table = 'kemasan_input_dokumentasi';

    protected $fillable = [
        'kemasan_input_id',
        'file_path',
    ];

    public function kemasanInput()
    {
        return $this->belongsTo(KemasanInput::class, 'kemasan_input_id');
    }
}
