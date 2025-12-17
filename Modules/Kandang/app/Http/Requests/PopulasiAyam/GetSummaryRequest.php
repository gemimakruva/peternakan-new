<?php

namespace Modules\Kandang\Http\Requests\PopulasiAyam;

use Illuminate\Foundation\Http\FormRequest;

class GetSummaryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'flock_id' => ['required', 'integer', 'exists:flock,id'],
            'date'     => ['required', 'date_format:Y-m-d'],
        ];
    }
}
