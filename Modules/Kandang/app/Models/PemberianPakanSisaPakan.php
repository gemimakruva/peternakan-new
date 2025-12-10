<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Kandang\Database\Factories\PemberianPakanSisaPakanFactory;
class PemberianPakanSisaPakan extends Model
{
    use HasFactory;

    /** Nama tabel (jika tidak sama dengan nama model dalam bentuk jamak) */
    protected $table = 'pemberian_pakan_sisa_pakan';

    /** Field yang boleh diisi (fillable) */
    protected $fillable = [
        'flock_id',
        'jenis_pakan_id',
        'user_executor_id',
        'tanggal',
        'pemberian_pakan_flock_kg',
        'sisa_pakan_per_flock_kg',
    ];

    public function flock()
{
    return $this->belongsTo(Flock::class, 'flock_id', 'id');
}

    public function jenisPakan()
{
    return $this->belongsTo(JenisPakan::class, 'jenis_pakan_id', 'id');
}

public function userExecutor()
{
    return $this->belongsTo(User::class, 'user_executor_id', 'id');
}

    protected static function newFactory()
{
    return PemberianPakanSisaPakanFactory::new();
}

}
