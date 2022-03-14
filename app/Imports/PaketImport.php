<?php

namespace App\Imports;

use App\Models\Paket;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PaketImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow(): int
    {
        return 3;
    }


    public function model(array $row)
    {
        return new Paket([
            'nama_paket' => $row['nama_paket'],
            'outlet_id' => Auth::user()->outlet_id,
            'jenis' => $row['jenis'],
            'harga' => $row['harga'],
        ]);
    }
}
