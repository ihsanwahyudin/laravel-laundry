<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class AbsensiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama_karyawan' => ['required'],
            'tanggal_masuk' => ['required', 'date'],
            'waktu_masuk' => ['required'],
            'status' => ['required', 'in:sakit,masuk,cuti'],
            // 'waktu_selesai_kerja' => ['required']
        ];
    }
}
