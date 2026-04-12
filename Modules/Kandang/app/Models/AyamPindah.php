<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AyamPindah extends Model
{
    protected $table = 'ayam_pindah';

    protected $fillable = [
        'tanggal',
        'user_pic_id',
        'populasi_ayam_id',
        'asal_pipe_id',
        'tujuan_pipe_id',
        'jumlah_perubahan',
    ];

    protected $casts = [
        'tanggal'          => 'date',
        'jumlah_perubahan' => 'integer',
    ];

    public function userPic()
    {
        return $this->belongsTo(User::class, 'user_pic_id');
    }

    public function populasiAyam()
    {
        return $this->belongsTo(PopulasiAyam::class, 'populasi_ayam_id');
    }

    public function asalPipe()
    {
        return $this->belongsTo(Pipe::class, 'asal_pipe_id');
    }

    public function tujuanPipe()
    {
        return $this->belongsTo(Pipe::class, 'tujuan_pipe_id');
    }
}
