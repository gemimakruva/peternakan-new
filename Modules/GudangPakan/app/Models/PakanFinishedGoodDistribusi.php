<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;

class PakanFinishedGoodDistribusi extends Model
{
    public $table = 'pakan_finished_good_distribusi';

    protected $fillable = [
        'pic_user_id',
        'formulasi_mix_id',
        'tanggal',
        'jumlah',
        'tujuan',
    ];
}
