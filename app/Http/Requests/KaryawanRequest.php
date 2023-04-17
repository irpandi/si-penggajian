<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class KaryawanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nik'          => 'numeric',
            'nameKaryawan' => 'required',
            'status'       => 'required',
            'noHp'         => 'required|numeric',
            'alamat'       => 'required',
        ];
    }

    // * Preparing message
    public function messages()
    {
        return [
            'nik.numeric'           => 'NIK harus angka',
            'nameKaryawan.required' => "Nama Karyawan wajib diisi",
            'status.required'       => 'Status wajib diisi',
            'noHp.required'         => 'Nomor Handphone wajib diisi',
            'noHp.numeric'          => 'Nomor Handphone harus angka',
            'alamat.required'       => 'Alamat wajib diisi',
        ];
    }
}
