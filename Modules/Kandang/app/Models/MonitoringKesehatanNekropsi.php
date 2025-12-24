<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringKesehatanNekropsi extends Model
{
    use HasFactory;

    protected $table = 'monitoring_kesehatan_nekropsi';

    protected $guarded = [];

    public function monitoring(): BelongsTo
    {
        return $this->belongsTo(MonitoringKesehatan::class, 'monitoring_kesehatan_id');
    }
}
