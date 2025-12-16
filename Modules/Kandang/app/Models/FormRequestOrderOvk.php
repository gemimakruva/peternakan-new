<?php


namespace Modules\Kandang\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class FormRequestOrderOvk extends Model
{
    use HasFactory;
    protected $table = "form_requets_order_ovk";

protected $fillable = [
    'kandang_id',
    'tanggal',
    'jenis_ovk',
    'merk_ovk',
    'kemasan_ovk',
    'total_kebutuhan_yang_diorder',
    'maksimal_kedatangan',
];

public function kandang()
{
    return $this->belongsTo(Kandang::class, 'kandang_id');
}

 protected static function newFactory()
    {
        return \Modules\Kandang\Database\Factories\FormRequestOvkFactory::new();
    }

}
