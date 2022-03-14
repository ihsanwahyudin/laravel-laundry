<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class BarangInventarisRequest extends FormRequest
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
            'merk_barang' => ['required'],
            'qty' => ['required', 'numeric', 'max:1000'],
            'kondisi' => ['required', 'in:layak_pakai,rusak_ringan,rusak_baru'],
            'tanggal_pengadaan' => ['required', 'date'],
        ];
    }
}
