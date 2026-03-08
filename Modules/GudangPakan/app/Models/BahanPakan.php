<?php

namespace Modules\GudangPakan\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Enums\BahanPakanTipe;
use Modules\GudangTelur\Models\Satuan;

class BahanPakan extends Model
{
    public $table = 'bahan_pakan';

    protected $fillable = [
        'satuan_id',
        'nama',
        'tipe',
        'harga',
        'harga_satuan',
    ];

    protected $casts = [
        'harga' => 'float',
        'harga_satuan' => 'float',
    ];

    public function satuan()
    {
        return $this->belongsTo(Satuan::class);
    }

    public function priceable()
    {
        return $this->morphMany(PerubahanHarga::class, 'priceable');
    }

    public function getTipeEnumAttribute()
    {
        if (!$this->attributes['tipe']) return null;
        return BahanPakanTipe::tryFrom($this->attributes['tipe']);
    }

    public function getJumlahSatuanAttribute()
    {
        if ($this->attributes['harga'] == 0 || $this->attributes['harga_satuan'] == 0) {
            return 0;
        }

        return round($this->attributes['harga'] / $this->attributes['harga_satuan']);
    }

    protected static function booted()
    {
        static::saved(function ($model) {
            if ($model->wasRecentlyCreated) {
                $model->priceable()->create([
                    'pic_user_id'   => auth()->id(),
                    'harga'         => $model->harga_satuan,
                ]);
            }

            if ($model->wasChanged('harga')) {
                $model->priceable()->create([
                    'pic_user_id'   => auth()->id(),
                    'harga'         => $model->harga_satuan,
                ]);
            }
        });
    }
}
