<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerhitunganPakan extends Model
{
    use HasFactory;

    protected $table = "perhitungan_pakan";

    protected $fillable = [
        'tanggal_pemberian_pakan',
        'kandang_id',
        'user_creator_id',
        'user_executor_id',
        'jenis_pakan_id',
        'proporsi_pemberian_pagi',
        'proporsi_pemberian_sore',
        'waktu_pemberian_pagi',
        'waktu_pemberian_sore',
        'catatan',
    ];

    protected $casts = [
        'tanggal_pemberian_pakan' => 'date'
    ];

    public function kandang()
    {
        return $this->belongsTo(Kandang::class, 'kandang_id');
    }

    public function userCreator()
    {
        return $this->belongsTo(User::class, 'user_creator_id');
    }

    public function userExecutor()
    {
        return $this->belongsTo(User::class, 'user_executor_id');
    }

    public function jenisPakan()
    {
        return $this->belongsTo(JenisPakan::class, 'jenis_pakan_id');
    }

    public function perhitunganPakanItems()
    {
        return $this->hasMany(PerhitunganPakanItem::class, 'perhitungan_pakan_id');
    }

    public function pemberianPakanSisaPakan()
    {
        return $this->hasMany(PemberianPakanSisaPakan::class, 'perhitungan_pakan_id', 'id');
    }

    protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\PerhitunganPakanFactory::new();
    }
}
