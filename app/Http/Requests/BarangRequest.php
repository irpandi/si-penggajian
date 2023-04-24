<?php

// * Author By : Rifki Irpandi

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BarangRequest extends FormRequest
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
            'nama'  => 'required',
            'merk'  => 'required',
            'total' => 'required|numeric',
        ];
    }

    // * Preparing Message
    public function messages()
    {
        return [
            'nama.required'  => 'Nama wajib diisi',
            'merk.required'  => 'Merk wajib diisi',
            'total.required' => 'Total wajib diisi',
            'total.numeric'  => 'Total harus angka',
        ];
    }
}
