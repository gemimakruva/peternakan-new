<?php

namespace Modules\Kandang\Http\Requests\MonitoringKesehatan;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'kandang_id'                          => ['required', 'integer', 'integer', 'exists:kandang,id'],
            'tanggal'                             => ['required', 'date_format:Y-m-d'],
            'tim_pelaksana'                       => ['required', 'string'],
            'total_populasi_ayam'                 => ['required', 'string'],
            'ayam_sehat'                          => ['required', 'integer'],
            'ayam_sakit'                          => ['required', 'integer'],
            'ayam_mati'                           => ['required', 'integer'],
            'ayam_afkir'                          => ['required', 'integer'],
            'detail_penyakit_ditemukan'           => ['required', 'string'],
            'umum_perilaku'                       => ['required', 'string'],
            'umum_kondisi_bulu'                   => ['required', 'string'],
            'umum_proporsi_tubuh'                 => ['required', 'string'],
            'umum_nafsu_makan'                    => ['required', 'string'],
            'umum_produktivitas_telur'            => ['required', 'string'],
            'lingkungan_suhu'                     => ['required', 'string'],
            'lingkungan_kelembapan'               => ['required', 'string'],
            'lingkungan_kebersihan'               => ['required', 'string'],
            'detail_kondisi_umum'                 => ['required', 'string'],
            'nekropsi_jumlah_ayam'                => ['required', 'integer'],
            'nekropsi'                            => ['nullable', 'array', Rule::when(fn($input) => $input['nekropsi_jumlah_ayam'] > 0, ['required']),],
            'nekropsi.*.image'                    => [Rule::when(fn($input) => $input['nekropsi_jumlah_ayam'] > 0, ['required']), 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'nekropsi.*.keterangan'               => [Rule::when(fn($input) => $input['nekropsi_jumlah_ayam'] > 0, ['required', 'string'])],
            'tindakan_pengobatan'                 => ['required', 'string'],
            'tindakan_rekomendasi_jangka_pendek'  => ['required', 'string'],
            'tindakan_rekomendasi_jangka_panjang' => ['required', 'string'],
            'evaluasi_efektivitas_pengobatan'     => ['required', 'string'],
            'evaluasi_catatan'                    => ['required', 'string'],
            'dokumentasi'                         => ['required', 'array'],
            'dokumentasi.*'                       => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }
}
