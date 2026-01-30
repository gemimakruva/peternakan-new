<?php

namespace Modules\Kandang\Http\Requests\PopulasiAyam;

use Illuminate\Foundation\Http\FormRequest;
use Modules\Kandang\Models\PopulasiAyam;
use Modules\Kandang\Services\KandangService;
use Modules\Kandang\Services\PopulasiAyamService;

class PopulasiAyamStore extends FormRequest
{
    protected function prepareForValidation()
    {
        $this->merge([
            'ayam_sehat' => $this->integer('jumlah_ayam_sehat_pada_pipa_saat_ini', 0)
                - $this->integer('ayam_mati', 0)
                - $this->integer('ayam_afkir', 0)
                - $this->integer('ayam_masuk_karantina', 0)
                + $this->integer('ayam_keluar_karantina', 0),
        ]);
    }

    public function rules(): array
    {
        return [
            'tanggal_transaksi' => ['required', 'date'],
            'kandang_id'        => ['required', 'exists:kandang,id'],
            'flock_id'          => ['required', 'exists:flock,id'],
            'pipe_id'           => ['required', 'exists:pipe,id', function ($attr, $value, $fail) {
                $isExist = app(PopulasiAyam::class)
                    ->query()
                    ->where('pipe_id', '=', $value)
                    ->where('tanggal', '=', request()->input('tanggal_transaksi'))
                    ->exists();
                if ($isExist) {
                    $pipe = $this->pipe->find($value);
                    $fail("Recording untuk pipe $pipe->nama sudah dilakukan.");
                }
            }],
            'umur_ayam_record'     => ['required', 'min:1'],
            'ayam_sehat'           => ['nullable', 'min:0'],
            'ayam_mati'            => ['nullable', 'min:0'],
            'ayam_afkir'           => ['nullable', 'min:0'],
            'ayam_masuk_karantina' => ['nullable', 'min:0', function ($attr, $value, $fail) {
                $value = (int) $value;

                if ($value > app(KandangService::class)->getCurrentAyamSehatByPipe(request()->input('pipe_id'))) {
                    $fail('ayam masuk karantina tidak boleh melebihi populasi ayam.');
                }
            }],
            'ayam_keluar_karantina' => ['nullable', 'min:0', function ($attr, $value, $fail) {
                $value = (int) $value;

                if (!request()->date('tanggal_transaksi')) {
                    $fail('The tanggal transaksi field is required.');
                }

                if (
                    request()->date('tanggal_transaksi') !== NULL
                    && $value > app(PopulasiAyamService::class)->getLatestKarantinaPopulasi(
                        request()->input('kandang_id'), 
                        request()->date('tanggal_transaksi')
                    )
                ) {
                    $fail('ayam keluar karantina tidak boleh melebihi populasi karantina.');
                }

                if ($value > app(KandangService::class)->getCurrentKapasitasPipeTersedia(request()->input('pipe_id')) + request()->integer('ayam_keluar_karantina')) {
                    $fail('ayam keluar karantina tidak boleh melebihi kapasitas pipe.');
                }
            }],
            'catatan' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
