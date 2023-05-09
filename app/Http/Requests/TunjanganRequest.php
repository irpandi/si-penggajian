<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TunjanganRequest extends FormRequest
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
            'namaTunjangan'   => 'required',
            'jumlahTunjangan' => 'required|numeric|min:0',
        ];
    }

    // * Preparing Messages
    public function messages()
    {
        return [
            'namaTunjangan.required'   => 'Nama tunjangan wajib diisi',
            'jumlahTunjangan.required' => 'Jumlah tunjangan wajib diisi',
            'jumlahTunjangan.numeric'  => 'Jumlah tunjangan harus angka',
            'jumlahTunjangan.min'      => 'Jumlah tunjangan minimal angka 0',
        ];
    }
}
