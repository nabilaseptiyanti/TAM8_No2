<?php

namespace Modules\KelolaKios\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class KiosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() && $this->user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $kios = $this->route('kios');
        $kiosId = $kios ? (is_object($kios) ? $kios->id : $kios) : null;

        return [
            'kode_kios' => [
                'required',
                'string',
                'max:50',
                Rule::unique('kios', 'kode_kios')->ignore($kiosId),
            ],
            'nama_kios' => ['required', 'string', 'max:150'],
            'nama_pemilik' => ['required', 'string', 'max:150'],
            'no_telp' => ['required', 'string', 'max:25'],
            'lokasi' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'kode_kios.required' => 'Kode kios wajib diisi.',
            'kode_kios.unique' => 'Kode kios ini sudah digunakan oleh kios lain.',
            'nama_kios.required' => 'Nama kios wajib diisi.',
            'nama_pemilik.required' => 'Nama pemilik kios wajib diisi.',
            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'lokasi.required' => 'Lokasi kios wajib diisi.',
        ];
    }
}
