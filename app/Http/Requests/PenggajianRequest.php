<?php

// * Author By : Rifki Irpandi

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PenggajianRequest extends FormRequest
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
            'tglPeriode'          => 'required',
            'karyawan'            => 'required',
            'barang'              => 'required',
            'item'                => 'required',
            'totalPengerjaanItem' => 'required|numeric|min:0',
        ];
    }

    // * Preparing message
    public function messages()
    {
        return [
            'tglPeriode.required'          => 'Tgl Periode wajib diisi',
            'karyawan.required'            => 'Karyawan wajib diisi',
            'barang.required'              => 'Barang wajib diisi',
            'item.required'                => 'Item wajib diisi',
            'totalPengerjaanItem.required' => 'Total pengerjaan item wajib diisi',
            'totalPengerjaanItem.numeric'  => 'Total pengerjaan item harus angka',
            'totalPengerjaanItem.min'      => 'Total pengerjaan item minimal angka 0',
        ];
    }
}
