<?php

namespace Modules\GudangTelur\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\GudangPakan\Models\PerubahanHarga;

class Kemasan extends Model
{
    public $table = 'kemasan';

    protected $fillable = [
        'satuan_id',
        'nama',
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

    protected static function booted()
    {
        static::updated(function ($model) {
            if (app()->runningInConsole()) {
                return;
            }

            \Log::info('trigger');

            if ($model->wasRecentlyCreated) {
                $model->priceable()->create([
                    'pic_user_id'   => auth()->id(),
                    'harga'         => $model->harga_satuan,
                ]);
            }

            if ($model->wasChanged('harga_satuan')) {
                $model->priceable()->create([
                    'pic_user_id'   => auth()->id(),
                    'harga'         => $model->harga_satuan,
                ]);
            }
        });
    }
}
