<?php

namespace Modules\Produk\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProdukRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama_produk' => ['required', 'string', 'max:150'],
            'kategori' => ['required', 'string', 'max:100'],
            'harga' => ['required', 'numeric', 'min:0'],
            'stok' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:2048'],
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'kategori.required' => 'Kategori produk wajib diisi.',
            'harga.required' => 'Harga produk wajib diisi.',
            'harga.numeric' => 'Harga harus berupa angka yang valid.',
            'harga.min' => 'Harga tidak boleh bernilai negatif.',
            'stok.required' => 'Jumlah stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh bernilai negatif.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
            'foto.file' => 'Berkas foto harus berupa file yang valid.',
            'foto.mimes' => 'Format file harus berupa JPG, JPEG, PNG, WEBP, atau PDF.',
            'foto.max' => 'Ukuran berkas maksimal 2 MB (2048 KB).',
        ];
    }
}
