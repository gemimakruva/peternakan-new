<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;

class KemasanInventory extends Model
{
    public $table = 'kemasan_inventory';

    protected $fillable = [
        'tipe',
        'supplier_id',
        'kemasan_input_id',
        'kemasan_output_id',
        'kemasan_opname_id',
        'kemasan_id',
        'tanggal',
        'jumlah',
        'harga_satuan',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer',
        'harga_satuan' => 'float',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function kemasanInput()
    {
        return $this->belongsTo(KemasanInput::class, 'kemasan_input_id');
    }

    public function kemasanOutput()
    {
        return $this->belongsTo(KemasanOutput::class, 'kemasan_output_id');
    }

    public function kemasanOpname()
    {
        return $this->belongsTo(KemasanOpname::class, 'kemasan_opname_id');
    }

    public function kemasan()
    {
        return $this->belongsTo(Kemasan::class, 'kemasan_id');
    }
}
