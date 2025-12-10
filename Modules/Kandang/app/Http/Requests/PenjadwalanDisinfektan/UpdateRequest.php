<?php

namespace Modules\Kandang\Http\Requests\PenjadwalanDisinfektan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kandang_id'                    => ['sometimes', 'integer', 'exists:kandang,id'],
            'tanggal'                       => ['sometimes', 'date_format:Y-m-d'],
            'detail_waktu'                  => ['sometimes', 'string'],
            'flocks'                        => ['sometimes', 'array', 'min:1'],
            'flocks.*.jenis_disinfektan_id' => ['sometimes', 'integer', 'exists:jenis_disinfektan,id'],
            'flocks.*.flock_id'             => ['sometimes', 'integer', 'exists:flock,id'],
            'flocks.*.area'                 => ['sometimes', 'string'],
            'flocks.*.merk_disinfektan'     => ['sometimes', 'string'],
            'flocks.*.dosis_per_tangki'     => ['sometimes', 'string'],
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
