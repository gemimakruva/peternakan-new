<?php

namespace Modules\Kandang\Http\Requests\AyamKarantina;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "ayam_mati" => ['required', 'numeric', 'min:0'],
            "ayam_afkir" => ['required', 'numeric', 'min:0'],
            "pemberian_pakan" => ['required', 'numeric', 'min:0'],
            "sisa_pakan" => ['required', 'numeric', 'min:0'],
            "jumlah_telur_bagus" => ['required', 'numeric', 'min:0'],
            "jumlah_telur_retak" => ['required', 'numeric', 'min:0'],
            "jumlah_telur_rusak" => ['required', 'numeric', 'min:0'],
            "berat_telur_bagus" => ['required', 'numeric', 'min:0'],
            "berat_telur_retak" => ['required', 'numeric', 'min:0'],
            "berat_telur_rusak" => ['required', 'numeric', 'min:0'],
            "pengobatan_yang_dilakukan" => ['nullable', 'string', 'max:255'],
            "jumlah_ayam_diobati" => ['required', 'numeric', 'min:0'],
            "penyemprotan" => ['nullable', 'string', 'max:255'],
            "vaksin" => ['nullable', 'string', 'max:255'],
            "catatan" => ['nullable', 'string', 'max:500'],
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
