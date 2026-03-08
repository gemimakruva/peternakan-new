<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanMixing extends Model
{
    public $table = 'pakan_mixing';
    
    protected $fillable = [
        'pic_user_id',
        'formulasi_mix_id',
        'tanggal',
        'jumlah_campuran',
        'harga_total',
    ];
}
