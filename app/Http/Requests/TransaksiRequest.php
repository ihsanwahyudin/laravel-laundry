<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TransaksiRequest extends FormRequest
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
            'member.id' => ['required', 'numeric'],
            'detailTransaksi.*.id' => ['required', 'numeric'],
            'detailTransaksi.*.qty' => ['required', 'numeric', 'min:1'],
            'detailTransaksi.*.keterangan' => ['nullable'],
            'transaksi.member_id' => ['required', 'numeric'],
            'transaksi.tgl_bayar' => ['required', 'date'],
            'transaksi.batas_waktu' => ['required', 'date'],
            'transaksi.metode_pembayaran' => ['required', 'in:cash,dp,bayar nanti'],
            'transaksi.status_transaksi' => ['required', 'in:baru,proses,selesai,diambil'],
            'transaksi.biaya_tambahan' => ['required', 'numeric'],
            'transaksi.diskon' => ['required', 'numeric', 'max:100', 'min:0'],
            'transaksi.pajak' => ['required', 'numeric', 'max:100', 'min:0'],
            'transaksi.total_pembayaran' => ['required', 'numeric'],
            'transaksi.total_bayar' => ['required', 'numeric'],
        ];
    }
}
