<?php

namespace App\Http\Requests\Pegawai;

use Illuminate\Foundation\Http\FormRequest;

class StorePegawaiRequest extends FormRequest
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
            'nip' => 'required|string|max:50|unique:pegawai',
            'nama_pegawai' => 'required|string|max:100',
            'no_telp' => 'required',
            'alamat' => 'required',
            'foto_pegawai' => 'nullable|image|mimes:jpg,png,jpeg|max:2000'
        ];
    }
}
