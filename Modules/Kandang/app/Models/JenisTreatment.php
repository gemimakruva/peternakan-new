<?php

namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTreatment extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'jenis_treatment';

    // Kolom yang bisa diisi mass-assignment
    protected $fillable = [
        'nama',
    ];


    protected static function newFactory()
{
    return \Modules\Kandang\Database\Factories\JenisTreatmentFactory::new();
}

}
