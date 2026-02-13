<?php

namespace Modules\Kandang\Http\Requests\Treatment;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'items'                         => ['required', 'array'],
            'items.*.id'                    => ['nullable', 'exists:treatment_jadwal,id'],
            'items.*.waktu'                 => ['required', 'date_format:H:i'],
            'items.*.jenis_treatment_id'    => ['required', 'integer', 'exists:jenis_treatment,id'],
            'items.*.metode_treatment_id'   => ['required', 'integer', 'exists:metode_treatment,id'],
            'items.*.merk_ovk'              => ['required', 'string', 'max:255'],
            'items.*.area'                  => ['nullable', 'string', 'max:255'],
            'items.*.flocks'                => ['nullable', 'array'],
            'items.*.flocks.*'              => ['required', 'integer', 'exists:flock,id'],
            'items.*.dosis'                 => ['nullable', 'string', 'max:255'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    public function attributes()
    {
        return [
            'items.*.waktu'                 => 'Waktu',
            'items.*.jenis_treatment_id'    => 'Jenis',
            'items.*.metode_treatment_id'   => 'Metode',
            'items.*.merk_ovk'              => 'Merk OVK',
            'items.*.area'                  => 'Area',
            'items.*.dosis'                 => 'Dosis',
        ];
    }
}
