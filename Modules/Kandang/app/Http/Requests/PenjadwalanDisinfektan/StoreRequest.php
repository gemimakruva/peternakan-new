<?php

namespace Modules\Kandang\Http\Requests\PenjadwalanDisinfektan;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kandang_id'                    => ['required', 'integer', 'exists:kandang,id'],
            'tanggal'                       => ['required', 'date_format:Y-m-d'],
            'detail_waktu'                  => ['required', 'string'],
            'flocks'                        => ['required', 'array', 'min:1'],
            'flocks.*.jenis_disinfektan_id' => ['required', 'integer', 'exists:jenis_disinfektan,id'],
            'flocks.*.flock_id'             => ['required', 'integer', 'exists:flock,id'],
            'flocks.*.area'                 => ['required', 'string'],
            'flocks.*.merk_disinfektan'     => ['required', 'string'],
            'flocks.*.dosis_per_tangki'     => ['required', 'string'],
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
