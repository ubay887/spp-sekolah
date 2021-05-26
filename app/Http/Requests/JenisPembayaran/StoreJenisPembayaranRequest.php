<?php

namespace App\Http\Requests\JenisPembayaran;

use Illuminate\Foundation\Http\FormRequest;

class StoreJenisPembayaranRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_pembayaran' => 'required|string|max:200',
            'tahunajaran_id' => 'required|exists:tahunajaran,id',
            'harga' => 'required|integer|min:1',
            'tipe' => 'required|max:100',
            // 'kelas_id' => 'required',
        ];
    }
}
