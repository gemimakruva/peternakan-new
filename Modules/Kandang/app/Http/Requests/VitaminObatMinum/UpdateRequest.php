<?php

namespace Modules\Kandang\Http\Requests\VitaminObatMinum;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'jenis_treatment_id'           => ['sometimes', 'integer', 'integer', 'exists:jenis_treatment,id'],
            'merk_ovk'                     => ['sometimes', 'string'],
            'dosis_pemberian'              => ['sometimes', 'numeric'],
            'satuan_per_dosis'             => ['sometimes', 'numeric'],
            'air_minum_per_ekor'           => ['sometimes', 'numeric'],
            'jumlah_ayam_per_baris'        => ['sometimes', 'integer'],
            'jumlah_air_di_tong_per_baris' => ['sometimes', 'numeric'],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
}
