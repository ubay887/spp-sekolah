<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
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
            'nis' => 'required|string|max:50|unique:siswa',
            'nama_lengkap' => 'required|string|max:100',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required',
            'kelas_id' => 'required',
            'no_telp' => 'required',
            'alamat' => 'required',
            'nama_ibu_kandung' => 'required',
            'nama_ayah_kandung' => 'required',  
            'no_telp_orangtua' => 'required',
            'foto_siswa' => 'nullable|image|mimes:jpg,png,jpeg|max:2000'
        ];
    }
}
