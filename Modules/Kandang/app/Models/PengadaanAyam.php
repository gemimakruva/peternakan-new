<?php

namespace Modules\Kandang\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PengadaanAyam extends Model
{
    protected $table = 'pengadaan_ayam';

    protected $fillable = [
        'kandang_id',
        'pic_user_id',
        'tanggal',
        'umur_ayam',
        'penyesuaian_hari_umur_ayam',
        'kondisi_ayam',
        'jumlah_ayam_datang',
        'jumlah_ayam_mati',
        'jumlah_ayam_sakit',
        'jumlah_ayam_masuk_kandang',
        'catatan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'umur_ayam' => 'integer',
        'penyesuaian_hari_umur_ayam' => 'integer',
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id', 'id');
    }

    public function picUser(){
        return $this->belongsTo(User::class, 'pic_user_id', 'id');
    }

    public function berkasSupplier()
    {
        return $this->hasMany(BerkasPengadaanAyam::class, 'pengadaan_ayam_id', 'id');
    }

    public function distribusi()
    {
        return $this->hasMany(PengadaanAyamDistribusi::class, 'pengadaan_ayam_id', 'id');
    }

    public function dokumentasi()
    {
        return $this->hasMany(PengadaanAyamDokumentasi::class, 'pengadaan_ayam_id', 'id');
    }

    public function getDistribusiJsonAttribute()
    {
        if (!$this->distribusi) return null;

        return $this->distribusi->map(function($item) {
            return [
                'id' => $item->id,
                'is_editable' => !!@$item?->pipe?->is_editable,
                'pengadaan_ayam_id' => $item->pengadaan_ayam_id,
                'flock_id' => $item->pipe->flock_id,
                'pipe_id' => $item->pipe_id,
                'jumlah_ayam' => $item->jumlah_ayam,
                'nama_flock' => $item->pipe->flock->nama,
                'nama_pipa' => $item->pipe->nama,
            ];
        });
    }

    public function getBerkasSupplierJsonAttribute()
    {
        if (!$this->berkasSupplier) return null;

        return $this->berkasSupplier->map(function($item) {
            return [
                
            ];
        });
    }

    public function getUmurAyamSaatIniAttribute()
    {
        if (!$this->attributes['tanggal'] || !$this->attributes['umur_ayam']) return null;
        return $this->getUmurAyam(today());
    }

    /**
     * get umur ayam dalam satuan minggu
     * @param Carbon $tanggalPembanding
     * @return float|null
     */
    public function getUmurAyam(Carbon $tanggalPembanding)
    {
        if (!$this->attributes['tanggal'] || !$this->attributes['umur_ayam']) return null;
        $tanggalPerbandingan = $tanggalPembanding->diffInWeeks($this->attributes['tanggal']);
        return $this->attributes['umur_ayam'] + floor(abs($tanggalPerbandingan));
    }
    
}
