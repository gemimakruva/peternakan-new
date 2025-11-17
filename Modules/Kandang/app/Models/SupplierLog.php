<?php

namespace Modules\Kandang\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierLog extends Model
{
    use HasFactory;

    protected $table = 'supplier_log';

    protected $fillable = [
        // Relasi utama
        'pipe_id',
        'flock_id',
        'house_id',

        // Data utama log
        'log_date',
        'bird_age',
        'bird_condition',

        // Data populasi
        'chicken_in',
        'died_daily',
        'culled_daily',
        'sick_daily',
        'healthy_daily',
        'chicken_added',

        // Akumulasi total
        'died_total',
        'culled_total',

        // Persentase indikator
        'mortality_rate',
        'cull_rate',

        // Dokumen & catatan
        'document_name',
        'supplier_document',
        'documentation_photo',
        'notes',

        // Relasi pencatat
        'recorded_by',
    ];

    /**
     * Relasi ke model Pipe
     */
    public function pipe()
    {
        return $this->belongsTo(Pipe::class, 'pipe_id');
    }

    /**
     * Relasi ke user pencatat
     */
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
