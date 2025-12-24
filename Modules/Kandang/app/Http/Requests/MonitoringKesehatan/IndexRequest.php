<?php

namespace Modules\Kandang\Http\Requests\MonitoringKesehatan;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'kandang_id'    => ['sometimes', 'integer', 'exists:kandang,id'],
            'tim_pelaksana' => ['sometimes', 'nullable', 'string'],
            'start_date'    => ['nullable', 'required_with:end_date', 'date_format:Y-m-d'],
            'end_date'      => ['nullable', 'required_with:start_date', 'date-format:Y-m-d'],
        ];
    }
}
