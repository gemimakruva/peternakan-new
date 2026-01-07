<?php

namespace Modules\Kandang\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Modules\Kandang\Enums\BerkasName;
use Modules\Kandang\Models\PengadaanAyam;
class BerkasPengadaanAyam extends Model
{
    protected $table = 'pengadaan_ayam_berkas_supplier';

    protected $fillable = [
        'pengadaan_ayam_id',
        'file_path',
        'nama_berkas',
    ];
    protected $appends = [
        'file_url',
        'file_name',
    ];

    public function pengadaanAyam()
    {
        return $this->belongsTo(PengadaanAyam::class,
         'pengadaan_ayam_id', 'id');
    }

    /**
     * Custom nama berkas field
     */
    public function getNamaBerkasDisplayAttribute(): string
    {
        try {
            $enumCase = BerkasName::from($this->nama_berkas);
            return $enumCase->title();
        } catch (\ValueError $e) {
            return $this->nama_berkas;
        }
    }

    public function getFileUrlAttribute()
    {
        if (!$this->attributes['file_path']) return null;

        return Storage::url($this->attributes['file_path']);
    }

    public function getFileNameAttribute()
    {
        if (!$this->attributes['file_path']) return null;

        return basename($this->attributes['file_path']);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($berkas) {
            if ($berkas->file_path) {
                Storage::disk('public')->delete($berkas->file_path);
            }
        });

        static::saving(function ($berkas) {
            if (
                $berkas->getOriginal('file_path')
                && $berkas->getOriginal('file_path') !== $berkas->file_path
            ) {
                Storage::disk('public')->delete($berkas->getOriginal('file_path'));
            }
        });
    }
}
