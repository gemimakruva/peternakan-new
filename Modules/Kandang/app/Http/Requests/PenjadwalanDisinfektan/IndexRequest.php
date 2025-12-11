<?php

namespace Modules\Kandang\Http\Requests\PenjadwalanDisinfektan;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'kandang_id' => ['sometimes', 'integer', 'exists:kandang,id'],
            'start_date' => ['nullable', 'required_with:end_date', 'date_format:Y-m-d'],
            'end_date'   => ['nullable', 'required_with:start_date', 'date-format:Y-m-d'],
        ];
    }
}
