<?php

namespace App\Http\Requests;

use App\Models\Periode;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PeriodeRequest extends FormRequest
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
            'tglPeriode' => 'required|unique:tbl_periode,tgl_periode',
        ];
    }

    // * Preparing request
    protected function prepareForValidation()
    {
        $this->merge([
            'tglPeriode' => Periode::changeTglPeriodeForValidation($this),
        ]);
    }

    // * Preparing message
    public function messages()
    {
        return [
            'tglPeriode.unique'   => "Tgl Periode sudah ada",
            'tglPeriode.required' => 'Tgl Periode wajib diisi',
        ];
    }
}
