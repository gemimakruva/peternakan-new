<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonitoringKesehatan extends Model
{
    use HasFactory;

    protected $table = 'monitoring_kesehatan';

    protected $fillable = [
        'tanggal',
        'tim_pelaksana',
        'kandang_id',
        'total_populasi_ayam',
        'ayam_sehat',
        'ayam_sakit',
        'ayam_mati',
        'ayam_afkir',
        'detail_penyakit_ditemukan',
        'umum_perilaku',
        'umum_kondisi_bulu',
        'umum_proporsi_tubuh',
        'umum_nafsu_makan',
        'umum_produktivitas_telur',
        'lingkungan_suhu',
        'lingkungan_kelembapan',
        'lingkungan_kebersihan',
        'detail_kondisi_umum',
        'nekropsi_jumlah_ayam',
        'tindakan_pengobatan',
        'tindakan_rekomendasi_jangka_pendek',
        'tindakan_rekomendasi_jangka_panjang',
        'evaluasi_efektivitas_pengobatan',
        'evaluasi_catatan',
        'dokumentasi',
    ];

    protected $casts = [
        'dokumentasi' => 'array',
    ];

    public function kandang(): BelongsTo
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function nekropsi(): HasMany
    {
        return $this->hasMany(MonitoringKesehatanNekropsi::class, 'monitoring_kesehatan_id');
    }
}
