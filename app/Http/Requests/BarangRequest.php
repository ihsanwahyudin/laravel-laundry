<?php

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
     * @return array
     */
    public function rules()
    {
        return [
            'nama_barang' => ['required'],
            'qty' => ['required', 'numeric', 'max:100', 'min:0'],
            'harga' => ['required', 'numeric'],
            'waktu_beli' => ['required', 'date'],
            'supplier' => ['required'],
            'status_barang' => ['required', 'in:diajukan_beli,habis,tersedia']
        ];
    }
}
