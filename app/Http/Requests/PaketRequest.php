<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PaketRequest extends FormRequest
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
            'outlet_id' => ['required', 'numeric'],
            'jenis' => ['required', 'in:kiloan,selimut,bed_cover,kaos,lain'],
            'nama_paket' => ['required'],
            'harga' => ['required', 'numeric']
        ];
    }
}
