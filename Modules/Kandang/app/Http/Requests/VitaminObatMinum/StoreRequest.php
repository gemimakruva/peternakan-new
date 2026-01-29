<?php

namespace Modules\Kandang\Http\Requests\VitaminObatMinum;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'flock_id'                     => ['required', 'integer', 'integer', 'exists:flock,id'],
            'jenis_treatment_id'           => ['required', 'integer', 'integer', 'exists:jenis_treatment,id'],
            'tanggal'                      => ['required', 'date_format:Y-m-d'],
            'merk_ovk'                     => ['required', 'string'],
            'dosis_pemberian'              => ['required', 'numeric'],
            'satuan_per_dosis'             => ['required', 'numeric'],
            'air_minum_per_ekor'           => ['required', 'numeric'],
            'jumlah_ayam_per_flock'        => ['required', 'integer'],
            'jumlah_air_di_tong_per_flock' => ['required', 'numeric'],
        ];
    }
}
