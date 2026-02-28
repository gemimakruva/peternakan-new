<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class TelurInventory extends Model
{
    public $table = 'telur_inventory';

    protected $fillable = [
        'telur_masuk_id',
        'telur_keluar_id',
        'telur_opname_id',
        'telur_jenis_id',
        'tanggal',
        'jumlah',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function telurMasuk()
    {
        return $this->belongsTo(TelurMasuk::class, 'telur_masuk_id', 'id');
    }

    public function telurKeluar()
    {
        return $this->belongsTo(TelurMasuk::class, 'telur_keluar_id', 'id');
    }

    public function telurOpname()
    {
        return $this->belongsTo(TelurMasuk::class, 'telur_opname_id', 'id');
    }

    public function telurJenis()
    {
        return $this->belongsTo(TelurJenis::class, 'telur_jenis_id', 'id');
    }
}
