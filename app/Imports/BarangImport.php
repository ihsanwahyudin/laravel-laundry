<?php

namespace App\Imports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
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
        return new Barang([
            'nama_barang' => $row['nama_barang'],
            'qty' => $row['qty'],
            'harga' => $row['harga'],
            'waktu_beli' => $row['waktu_beli'],
            'supplier' => $row['supplier'],
            'status_barang' => $row['status_barang'],
        ]);
    }
}
