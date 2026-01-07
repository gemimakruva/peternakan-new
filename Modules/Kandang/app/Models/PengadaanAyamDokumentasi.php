<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Kandang\Models\PengadaanAyam;

class PengadaanAyamDokumentasi extends Model
{
    protected $table = 'pengadaan_ayam_dokumentasi';

    protected $fillable = [
        'pengadaan_ayam_id',
        'file_path',
    ];

    protected $appends = [
        'file_url',
    ];

    public function pengadaanAyam()
    {
        return $this->belongsTo(PengadaanAyam::class, 'pengadaan_ayam_id');
    }

    public function getFileUrlAttribute()
    {
        if (!$this->attributes['file_path']) return null;

        return Storage::url($this->attributes['file_path']);
    }

    protected static function booted()
    {
        parent::booted();

        static::deleting(function ($dokumentasi) {
            if ($dokumentasi->file_path) {
                Storage::disk('public')->delete($dokumentasi->file_path);
            }
        });

        static::saving(function ($dokumentasi) {
            if (
                $dokumentasi->getOriginal('file_path')
                && $dokumentasi->getOriginal('file_path') !== $dokumentasi->file_path
            ) {
                Storage::disk('public')->delete($dokumentasi->getOriginal('file_path'));
            }
        });
    }
}
