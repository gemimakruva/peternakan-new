<?php

namespace Modules\Kandang\Http\Requests\MonitoringKesehatan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'tim_pelaksana'                       => ['sometimes', 'string'],
            'total_populasi_ayam'                 => ['sometimes', 'string'],
            'ayam_sehat'                          => ['sometimes', 'integer'],
            'ayam_sakit'                          => ['sometimes', 'integer'],
            'ayan_mati'                           => ['sometimes', 'integer'],
            'ayam_afkir'                          => ['sometimes', 'integer'],
            'detail_penyakit_ditemukan'           => ['sometimes', 'string'],
            'umum_perilaku'                       => ['sometimes', 'string'],
            'umum_kondisi_bulu'                   => ['sometimes', 'string'],
            'umum_proporsi_tubuh'                 => ['sometimes', 'string'],
            'umum_nafsu_makan'                    => ['sometimes', 'string'],
            'umum_produktivitas_telur'            => ['sometimes', 'string'],
            'lingkungan_suhu'                     => ['sometimes', 'string'],
            'lingkungan_kelembapan'               => ['sometimes', 'string'],
            'lingkungan_kebersihan'               => ['sometimes', 'string'],
            'detail_kondisi_umum'                 => ['sometimes', 'string'],
            'nekropsi_jumlah_ayam'                => ['sometimes', 'integer'],
            'nekropsi'                            => ['sometimes', 'array'],
            'nekropsi.*.id'                       => ['sometimes', 'nullable', 'integer'],
            'nekropsi.*.image'                    => ['sometimes', 'nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'nekropsi.*.keterangan'               => ['sometimes', 'nullable', 'string'],
            'tindakan_pengobatan'                 => ['sometimes', 'string'],
            'tindakan_rekomendasi_jangka_pendek'  => ['sometimes', 'string'],
            'tindakan_rekomendasi_jangka_panjang' => ['sometimes', 'string'],
            'evaluasi_efektivitas_pengobatan'     => ['sometimes', 'string'],
            'evaluasi_catatan'                    => ['sometimes', 'string'],
            'existing_dokumentasi'                => ['sometimes', 'array'],
            'existing_dokumentasi.*'              => ['sometimes', 'string'],
            'dokumentasi'                         => ['sometimes', 'array'],
            'dokumentasi.*'                       => ['sometimes', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
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
