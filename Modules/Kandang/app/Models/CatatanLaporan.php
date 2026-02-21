<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class CatatanLaporan extends Model
{
    public $table = 'catatan_laporan';

    protected $fillable = [
        'creator_user_id',
        'kandang_id',
        'umur',
        'tanggal',
        'tipe',
        'catatan_populasi',
        'catatan_kematian',
        'catatan_konsumsi',
        'catatan_produksi_telur',
        'catatan_kpi_produksi',
        'catatan_keseluruhan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function creatorUserId()
    {
        return $this->belongsTo(User::class, 'creator_user_id', 'id');
    }

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }
}
