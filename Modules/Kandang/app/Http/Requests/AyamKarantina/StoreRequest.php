<?php

namespace Modules\Kandang\Http\Requests\AyamKarantina;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Kandang\Models\KarantinaPopulasi;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            "kandang_id"            => ['required', 'numeric', 'exists:kandang,id'],
            "total_ayam_karantina"  => ['required', 'numeric'],
            "tanggal"               => ['required', 'date', function($attribute, $value, $fail) {
                $exists = KarantinaPopulasi::where('kandang_id', $this->input('kandang_id'))
                    ->whereDate('tanggal', $value)
                    ->exists();
                if ($exists) {
                    $fail('Data untuk kandang dan tanggal yang sama sudah ada.');
                }
            }],
            "ayam_mati"             => ['required', 'numeric', 'min:0'],
            "ayam_afkir"            => ['required', 'numeric', 'min:0'],
            "pemberian_pakan"       => ['required', 'numeric', 'min:0'],
            "sisa_pakan"            => ['required', 'numeric', 'min:0'],
            "jumlah_telur_bagus"    => ['required', 'numeric', 'min:0'],
            "jumlah_telur_retak"    => ['required', 'numeric', 'min:0'],
            "jumlah_telur_rusak"    => ['required', 'numeric', 'min:0'],
            "berat_telur_bagus"     => ['required', 'numeric', 'min:0'],
            "berat_telur_retak"     => ['required', 'numeric', 'min:0'],
            "berat_telur_rusak"     => ['required', 'numeric', 'min:0'],
            "pengobatan_yang_dilakukan" =>  ['nullable', 'string', 'max:255'],
            "jumlah_ayam_diobati"   => ['required', 'numeric', 'min:0'],
            "penyemprotan"          => ['nullable', 'string', 'max:255'],
            "vaksin"                => ['nullable', 'string', 'max:255'],
            "catatan"               => ['nullable', 'string', 'max:500'],
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
